<?php

namespace App\Http\Controllers;

use URL;
use App\Models\User;
use config\constants;
use App\Models\Cities;
use App\Models\Patient;
use App\Models\MixedTables;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

class PatientController extends Controller
{
    public function index(Request $request)
    {
        if($request->session()->get('isSetDefault')==1){
            return View("pages.addPatient");
        }
        else{
            return redirect()->action(
                [DashboardController::class, 'getDefaultSetting'], ['id' =>  $request->session()->get('userId')]
            );
        }
    }
    public function searchIndex()
    {
        return View("pages.searchPatient");
    }
    public function registerPatient(Request $request)
    {
        try{
            $result=array();
            DB::beginTransaction();
            $validateUser=Validator::make($request->all(), [
                'name'=>'required',
                'phoneNo'=>'required',
                'email'=>'required',
                // 'profileImage'=>'required',
            ]);
            if($validateUser->fails()){
                $result['ShowModal']=1;
                $result['Success']='Failure';
                $result['Message']="Validation failed. Please fill the required field marked as *";
                return response()->json($result,200);
            }

            $hospitalId=(isset($request->hospitalId) && !empty($request->hospitalId)) ?$request->hospitalId : NULL;
            $branchId=(isset($request->branchId) && !empty($request->branchId)) ?$request->branchId : NULL;
            //Decrypt --- BEGIN
            $user = new User;
            $decrpt_hospitalId=($hospitalId==NULL?$hospitalId:$user->getDecryptedId($hospitalId));
            $decrpt_branchId=($branchId==NULL?$branchId:$user->getDecryptedId($branchId));
            $decrpt_hospitalId=($decrpt_hospitalId ==0 ? NULL :$decrpt_hospitalId);
            $decrpt_branchId=($decrpt_branchId==0 ? NULL : $decrpt_branchId);
            //Decrypt --- END

             //----------------Store Image ---Begin 
             $url = request()->getSchemeAndHttpHost();//URL::to("/");
             $profileImage =$url ."/". config('constant.doctor_default_profileImage');
            if($request->profileImage!=NULL && $request->profileImage!="")
            {
                $folderPath = 'images/patients/';
                $image_parts = explode(";base64,", $request->profileImage);
                $image_type_aux = explode("image/", $image_parts[0]);
                $image_type = $image_type_aux[1];
                $image_base64 = base64_decode($image_parts[1]);
                $fileName = config('constant.prefix_patient_profile_image').$decrpt_hospitalId.'_'.uniqid(). '.png';
                $profileImage = $folderPath . $fileName;
                file_put_contents($profileImage, $image_base64);
                $profileImage=$url .config('constant.imageStoreLocation'). $profileImage;
            }
             //-------------------Store Image ---End

            $patient_obj = new Patient;
            $chkPhoneNo=$patient_obj->checkPhoneNo($request->phoneNo,$decrpt_hospitalId,$decrpt_branchId);
            if($chkPhoneNo!=NULL){
                $result['ShowModal']=1;
                $result['Success']='Phone No already exists.';
                $result['Message']="Phone No registered patient number : ".$chkPhoneNo->hcNo;
                return response()->json($result,200);
            }
            $hcNo=$patient_obj->generateHcNo($decrpt_hospitalId);
            $patients =  $patient_obj->addPatient($request,$hcNo,$decrpt_hospitalId,$decrpt_branchId,$profileImage); 
            $result['ShowModal']=1;
            $result['Success']='Success';
            $result['Message']="Patient registered successfully";
            $result['hcNo']="Patient registered Number is ".$hcNo;
            $result['profileImage']=$profileImage;
            DB::commit();
            return response()->json($result,200);
        }catch(\Throwable $th){
            $result['ShowModal']=1;
            $result['Success']='failure';
            $result['Message']=$th->getMessage();
            return response()->json($result,200);
        }
    }
    public function getAllPatient(Request $request)
    {
        try{
            $pagination['page']=(isset($request->page) && !empty($request->page)) ?$request->page : 1;
            $pagination['size']=(isset($request->size) && !empty($request->size)) ?$request->size : 10;
            $pagination['sorters_field']=(isset($request->sorters[0]['field']) && !empty($request->sorters[0]['field'])) ?$request->sorters[0]['field'] : "created_date";
            $pagination['sorters_dir']=(isset($request->sorters[0]['dir']) && !empty($request->sorters[0]['dir'])) ?$request->sorters[0]['dir'] : "desc";

            $pagination['filters_field']=(isset($request->filters[0]['field']) && !empty($request->filters[0]['field'])) ?$request->filters[0]['field'] : "";
            $pagination['filters_type']=(isset($request->filters[0]['type']) && !empty($request->filters[0]['type'])) ?$request->filters[0]['type'] : "";
            $pagination['filters_value']=(isset($request->filters[0]['value']) && !empty($request->filters[0]['value'])) ?$request->filters[0]['value'] :"";

            $hospitalId=(isset($request->hospitalId) && !empty($request->hospitalId)) ?$request->hospitalId : NULL;
            $branchId=(isset($request->branchId) && !empty($request->branchId)) ?$request->branchId : 0;

            //Decrypt --- BEGIN
            $user = new User;
            $decrpt_hospitalId=($hospitalId==NULL?$hospitalId:$user->getDecryptedId($hospitalId));
            $decrpt_branchId=($branchId==NULL?$branchId:$user->getDecryptedId($branchId));
            //Decrypt --- END

            $patient_obj = new Patient;
            $patientList=$patient_obj->getAllPatient($decrpt_hospitalId,$decrpt_branchId,$pagination);
            
            $result['last_page']=$patientList['last_page'];
            $result['data']=$patientList['patientList'];
            return response()->json($result,200);
        }catch(\Throwable $th){
            $result['Success']='failure';
            $result['Message']=$th->getMessage();
            return response()->json($result,200);
        }
    }
    public function showEdit(Request $request,$id){
        try{
            $id_orignal="AES_DECRYPT(UNHEX('".$id."'), UNHEX(SHA2('".config('constant.mysql_custom_encrypt_key')."',512)))";
            $patient_obj = new Patient;
            $patientDetails=$patient_obj->getPatientById($id_orignal);
            $cities = new Cities;
            $patientDetails->city_list =  $cities->getCities(); 

            $mixedTable = new MixedTables;
            $patientDetails->genderList =  $mixedTable->getConsantValue(config('constant.genderTableId'));
            $patientDetails->maritalStatusList=$mixedTable->getConsantValue(config('constant.martialStatusTableId'));
            $patientDetails->refferedByList=$mixedTable->getConsantValue(config('constant.refferedByTableId'));
            $patientDetails->bloodGrp=$mixedTable->getConsantValue(config('constant.bloodGrpTableId'));

            return view('pages.editPatient')->with('patientDetails', $patientDetails);
        }catch(\Throwable $th){
            return Redirect::back()->withErrors($th->getMessage());
        }
    }

    public function getPatientById(Request $request,$id){
        try{
            $id_orignal="AES_DECRYPT(UNHEX('".$id."'), UNHEX(SHA2('".config('constant.mysql_custom_encrypt_key')."',512)))";
            $patient_obj = new Patient;
            $patientDetails=$patient_obj->getPatientById($id_orignal);
            $result['Success']='Success';
            $result['patientDetails']=$patientDetails;
            return response()->json($result,200);
        }catch(\Throwable $th){
            $result['Success']='failure';
            $result['Message']=$th->getMessage();
            return response()->json($result,200);
        }
    }
    public function updatePatient(Request $request)
    {
        try{
            $result=array();
            DB::beginTransaction();
            $validateUser=Validator::make($request->all(), [
                'name'=>'required',
                'phoneNo'=>'required',
                'email'=>'required'
            ]);
            if($validateUser->fails()){
                $result['ShowModal']=1;
                $result['Success']='Failure';
                $result['Message']="Validation failed. Please fill the required field marked as *";
                return response()->json($result,200);
            }
            $patient_obj = new Patient;
            $patientId="AES_DECRYPT(UNHEX('".$request->patientId."'), UNHEX(SHA2('".config('constant.mysql_custom_encrypt_key')."',512)))";
            $chkPhoneNo=$patient_obj->checkPhoneNoById($request->phoneNo,$patientId);
            if($chkPhoneNo!=NULL){
                $result['ShowModal']=1;
                $result['Success']='Phone No already exists.';
                $result['Message']="Phone No registered patient number : ".$chkPhoneNo->hcNo;
                return response()->json($result,200);
            }
            //----------------Store Image ---Begin 
            $profileImage="";
            if($request->isImageChanged==1){
                $url =request()->getSchemeAndHttpHost();// URL::to("/");
                $profileImage =$url ."/". config('constant.doctor_default_profileImage');
                if($request->profileImage!=NULL && $request->profileImage!="")
                {
                    $user = new User;
                    $patientId=$user->getDecryptedId($request->patientId);

                    $folderPath = 'images/patients/';
                    $image_parts = explode(";base64,", $request->profileImage);
                    $image_type_aux = explode("image/", $image_parts[0]);
                    $image_type = $image_type_aux[1];
                    $image_base64 = base64_decode($image_parts[1]);
                    $fileName = config('constant.prefix_patient_profile_image').$patientId.'_'.uniqid(). '.png';
                    $profileImage = $folderPath . $fileName;
                    file_put_contents($profileImage, $image_base64);
                    $url = request()->getSchemeAndHttpHost();//URL::to("/");
                    $profileImage=$url .config('constant.imageStoreLocation'). $profileImage;
                }
            }
             //-------------------Store Image ---End

            $patients = $patient_obj->updatePatient($request,$profileImage); 

            $result['ShowModal']=1;
            $result['Success']='Success';
            $result['Message']="Patient updated successfully";
            DB::commit();
            return response()->json($result,200);
        }catch(\Throwable $th){
            $result['ShowModal']=1;
            $result['Success']='failure';
            $result['Message']=$th->getMessage();
            return response()->json($result,200);
        }
    }
    public function deletePatient(Request $request,$id,$userId){
        try{
            $patient_obj = new Patient;
            $patientDetails=$patient_obj->deletePatientById($id,$userId);
            $result['Success']='Success';
            $result['ShowModal']= 1;
            $result['patientDetails']=$patientDetails;
            return response()->json($result,200);
        }catch(\Throwable $th){
            $result['Success']='failure';
            $result['Message']=$th->getMessage();
            return response()->json($result,200);
        }
    }   
}
