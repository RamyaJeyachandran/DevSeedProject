<?php

namespace App\Http\Controllers;

use URL;
use App\Models\User;
use config\constants;
use App\Models\doctor;
use App\Models\MixedTables;
use App\Models\AssignDoctor;
use Illuminate\Http\Request;
use App\Models\HospitalBranch;
use App\Models\DoctorSignature;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

class DoctorController extends Controller
{
    /**
     * Display a add doctor screen
     */
    
    public function index()
    {
        return View("pages.addDoctor");
    }
    public function searchIndex()
    {
        return View("pages.searchDoctor");
    }
    public function assignIndex()
    {
        return View("pages.addAssignDoctor");
    }
    public function listIndex()
    {
        return View("pages.searchAssignDoctor");
    }
    public function getAllDoctor(Request $request)
    {
        try{
            $pagination['page']=(isset($request->page) && !empty($request->page)) ?$request->page : 1;
            $pagination['size']=(isset($request->size) && !empty($request->size)) ?$request->size : 10;
            $pagination['sorters_field']=(isset($request->sorters[0]['field']) && !empty($request->sorters[0]['field'])) ?$request->sorters[0]['field'] : "doctors.created_date";
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

            $doctor_obj = new Doctor;
            $doctorList=$doctor_obj->getAllDoctor($decrpt_hospitalId,$decrpt_branchId,$pagination);
            
            $result['last_page']=$doctorList['last_page'];
            $result['data']=$doctorList['doctorList'];
            return response()->json($result,200);
        }catch(\Throwable $th){
            $result['Success']='failure';
            $result['Message']=$th->getMessage();
            return response()->json($result,200);
        }
    }
    public function registerDoctor(Request $request)
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
            $hospitalId=(isset($request->hospitalId) && !empty($request->hospitalId)) ?$request->hospitalId : NULL;
            $branchId=(isset($request->branchId) && !empty($request->branchId)) ?$request->branchId : NULL;

            //Decrypt --- BEGIN
            $user_obj = new User;
            $decrpt_hospitalId=($hospitalId==NULL?$hospitalId:$user_obj->getDecryptedId($hospitalId));
            $decrpt_branchId=($branchId==NULL?$branchId:$user_obj->getDecryptedId($branchId));

            $decrpt_hospitalId=($decrpt_hospitalId ==0 ? NULL :$decrpt_hospitalId);
            $decrpt_branchId=($decrpt_branchId==0 ? NULL : $decrpt_branchId);
            //Decrypt --- END

            //----------------Store Image ---Begin 
            $url = request()->getSchemeAndHttpHost();//URL::to("/");
            $profileImage =$url .config('constant.doctor_default_profileImage');
            if($request->hasfile('profileImage')){
                $hospital_id_store=($hospitalId==NULL?0:$decrpt_hospitalId);
                $img_location="images/doctors/";
                $img_name =config('constant.prefix_doctor_profile_image').$hospital_id_store.'_'.time().'.'.$request->profileImage->getClientOriginalExtension();
                $request->profileImage->move(public_path($img_location), $img_name);

                $profileImage =$img_location.$img_name;
                $profileImage=$url ."/". $profileImage;
            }
            //-------------------Store Image ---End
                      
            $doctor_obj = new Doctor;
            //Check phone no -- Begin
            $chkPhoneNo=$doctor_obj->checkPhoneNo($request->phoneNo,$decrpt_hospitalId,$decrpt_branchId);
            if($chkPhoneNo!=NULL){
                $result['ShowModal']=1;
                $result['Success']='Phone No already exists.';
                $result['Message']="Phone No registered doctor number is ".$chkPhoneNo->doctorCodeNo;
                return response()->json($result,200);
            }
            //Check phone no -- Begin
            
            //Generate doctor code number 
            $doctorCodeNo=$doctor_obj->generateDoctorCodeNo($decrpt_hospitalId);
            $doctors =  $doctor_obj->addDoctor($request,$doctorCodeNo,$profileImage,$decrpt_hospitalId,$decrpt_branchId); 
            $doctorId=$doctors->id;
            
            if($doctorId>0){
                //Add Doctor Signature BEGIN
                $doctorsign_obj = new DoctorSignature;
                $decrpt_userId=$user_obj->getDecryptedId($request->userId);
                 //----------------Store signature ---Begin 
                    $url = request()->getSchemeAndHttpHost();//URL::to("/");
                    $signature =$url .config('constant.doctor_default_profileImage');
                    $files = $request->file('signature');

                    if($request->hasFile('signature'))
                    {
                        foreach ($files as $file) {
                            $hospital_id_store=($hospitalId==NULL?0:$decrpt_hospitalId);
                            $img_location="images/doctors/";
                            $img_name =config('constant.prefix_doctor_signature').$hospital_id_store.'_'.time().'.'.$file->getClientOriginalExtension();
                            $file->move(public_path($img_location), $img_name);
                            $signature =$img_location.$img_name;
                            $signature =$url ."/". $signature;
                             //-------------------Store signature ---End

                            $doctorSignature =  $doctorsign_obj->addDoctorSignature($decrpt_hospitalId,$decrpt_branchId,$doctorId,$signature,$decrpt_userId); 
                            $doctorSignatureId=$doctorSignature->id;
                            if($doctorSignatureId<=0){
                                DB::rollback();
                                $result['ShowModal'] = 1;
                                $result['Success'] = 'Doctor Signature upload failed.';
                                $result['Message'] = "Please retry it.";
                                return response()->json($result, 200);
                            }
                        }
                    }
                //Add Doctor Signature END
            }

            //Login creation
            if($doctorId>0){
                 
                $login_created=0;
                $password=(isset($request->password) && !empty($request->password)) ?$request->password : NULL;
                if($password!=NULL){
                    $chkEmail=$user_obj->checkEmailId($request->email);
                    if(count($chkEmail)>0){
                        DB::rollback();
                        $result['ShowModal'] = 1;
                        $result['Success'] = 'Email id already exists for another user.';
                        $result['Message'] = "Please change the email id.";
                        return response()->json($result, 200);
                    }else{
                        $user_details=$user_obj->createLogin($request,config('constant.doctor_user_type_id'),$doctorId,$request->name);
                        $login_created=1;
                    }
                }
            }

            $result['ShowModal']=1;
            $result['Success']='Success';
            $result['Message']="Doctor registered successfully";
            $result['doctorCodeNo']="Doctor Access Number is ".$doctorCodeNo;
            $result['loginCreation']=$doctorId;
            DB::commit();
            return response()->json($result,200);
        }catch(\Throwable $th){
            $result['ShowModal']=1;
            $result['Success']='failure';
            $result['Message']=$th->getMessage();
            return response()->json($result,200);
        }
    }

    public function updateDoctor(Request $request)
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
            $hospitalId=(isset($request->hospitalId) && !empty($request->hospitalId)) ?$request->hospitalId : NULL;
            $branchId=(isset($request->branchId) && !empty($request->branchId)) ?$request->branchId : NULL;
            
            //Decrypt --- BEGIN
            $user_obj = new User;
            $decrpt_hospitalId=($hospitalId==NULL?$hospitalId:$user_obj->getDecryptedId($hospitalId));
            $decrpt_branchId=($branchId==NULL?$branchId:$user_obj->getDecryptedId($branchId));
            $decrpt_userId=$user_obj->getDecryptedId($request->userId);

            //Decrypt --- END

            //----------------Store Image ---Begin 
            $profileImage="";
            if($request->isImageChanged==1)
            {
                $url = request()->getSchemeAndHttpHost();//URL::to("/");
                $profileImage =$url .config('constant.doctor_default_profileImage');
                if($request->hasfile('profileImage')){
                    $hospital_id_store=($hospitalId==NULL?0:$decrpt_hospitalId);
                    $img_location="images/doctors/";
                    $img_name =config('constant.prefix_doctor_profile_image').$hospital_id_store.'_'.time().'.'.$request->profileImage->getClientOriginalExtension();
                    $request->profileImage->move(public_path($img_location), $img_name);

                    $profileImage =$img_location.$img_name;
                    $profileImage=$url ."/". $profileImage;
                }
            }
            
            //-------------------Store Image ---End

            $doctor_obj = new Doctor;
            $doctorId="AES_DECRYPT(UNHEX('".$request->doctorId."'), UNHEX(SHA2('".config('constant.mysql_custom_encrypt_key')."',512)))";
            $chkPhoneNo=$doctor_obj->checkPhoneNoById($request->phoneNo,$doctorId);
            if($chkPhoneNo!=NULL){
                $result['ShowModal']=1;
                $result['Success']='Phone No already exists.';
                $result['Message']="Phone No registered doctor number : ".$chkPhoneNo->doctorCodeNo;
                return response()->json($result,200);
            }
            $user_obj = new User;
             $chkEmail = $user_obj->checkEmailIdForEdit($request->email,$request->doctorId);
             if (count($chkEmail) > 0) {
                 $result['ShowModal'] = 1;
                 $result['Success'] = 'Email id already exists for another user.';
                 $result['Message'] = "Please change the email id.";
                 return response()->json($result, 200);
             } else {
                 $user_obj->updateLogin($request->doctorId,$request->userId,$request->name,$request->email,config('constant.doctor_user_type_id'));
             }

            $doctors = $doctor_obj->updateDoctor($request,$profileImage); 

            // UPDATE - Doctor Signature

             $signature="";
             $doctorsign_obj = new DoctorSignature;
             if($request->isSignChanged==1)
             {
                $decrpt_doctorId=$user_obj->getDecryptedId($request->doctorId);

             //----------------Store signature ---Begin 
                 $url = request()->getSchemeAndHttpHost();//URL::to("/");
                 $signature =$url .config('constant.doctor_default_profileImage');
                 $files = $request->file('signature');

                 if($request->hasFile('signature'))
                 {
                     foreach ($files as $file) {
                         $hospital_id_store=($hospitalId==NULL?0:$decrpt_hospitalId);
                         $img_location="images/doctors/";
                         $img_name =config('constant.prefix_doctor_signature').$hospital_id_store.'_'.time().'.'.$file->getClientOriginalExtension();
                         $file->move(public_path($img_location), $img_name);
                         $signature =$img_location.$img_name;
                         $signature =$url ."/". $signature;
                          //-------------------Store signature ---End

                         $doctorSignature =  $doctorsign_obj->addDoctorSignature($decrpt_hospitalId,$decrpt_branchId,$decrpt_doctorId,$signature,$decrpt_userId); 
                         $doctorSignatureId=$doctorSignature->id;
                         if($doctorSignatureId<=0){
                             DB::rollback();
                             $result['ShowModal'] = 1;
                             $result['Success'] = 'Doctor Signature upload failed.';
                             $result['Message'] = "Please retry it.";
                             return response()->json($result, 200);
                         }
                     }
                 }
             }
             //------------------- UPDATE Doctor signature ---End
             // DELETE Doctor Signature
             if($request->deletedSignature != '' || $request->deletedSignature != null){
                $signatureIds_list=explode(",",$request->deletedSignature);
                if(count($signatureIds_list)> 0)
                {
                    foreach( $signatureIds_list as $value ){
                        $doctorsign_obj->deleteSignature($value,$decrpt_userId);
                    }
                }
             }

            $result['ShowModal']=1;
            $result['Success']='Success';
            $result['Message']="Doctor updated successfully";
            DB::commit();
            return response()->json($result,200);
        }catch(\Throwable $th){
            $result['ShowModal']=1;
            $result['Success']='failure';
            $result['Message']=$th->getMessage();
            return response()->json($result,200);
        }
    }
    public function deleteDoctor(Request $request,$id,$userId){
        try{
            $doctor_obj = new Doctor;
            $doctorDetails=$doctor_obj->deleteDoctorById($id,$userId);
            $user_obj=new User;
            $user_login=$user_obj->deleteLogin($id,config("constant.doctor_user_type_id"),$userId);
            $result['Success']='Success';
            $result['ShowModal']= 1;
            $result['doctorDetails']=$doctorDetails;
            return response()->json($result,200);
        }catch(\Throwable $th){
            $result['Success']='failure';
            $result['Message']=$th->getMessage();
            return response()->json($result,200);
        }
    } 
   
    public function showEdit(Request $request,$id){
        try{
            $doctor_obj = new Doctor;
            $doctorDetails=$doctor_obj->getDoctorById($id);

            $mixedTable = new MixedTables;
            $doctorDetails->genderList =  $mixedTable->getConsantValue(config('constant.genderTableId'));
            $doctorDetails->bloodGrpList=$mixedTable->getConsantValue(config('constant.bloodGrpTableId'));
            $doctorDetails->departmentList=$mixedTable->getDepartment();
            $sign_obj=new DoctorSignature;
            $doctorDetails->signatureList=$sign_obj->getDoctorSignatureByDoctorId($id);
            $doctorDetails->signLength=$doctorDetails->signatureList->count();

            return view('pages.editDoctor')->with('doctorDetails', $doctorDetails);
        }catch(\Throwable $th){
            return Redirect::back()->withErrors($th->getMessage());
        }
    }
    public function getDoctorById(Request $request,$id){
        try{
            $doctor_obj = new doctor;
            $patientDetails=$doctor_obj->getDoctorById($id);
            $result['Success']='Success';
            $result['doctorDetails']=$patientDetails;
            return response()->json($result,200);
        }catch(\Throwable $th){
            $result['Success']='failure';
            $result['Message']=$th->getMessage();
            return response()->json($result,200);
        }
    }
    public function getDoctorByDepartment(Request $request,$hospitalId,$branchId,$departmentId){
        try{
            $doctor_obj =new Doctor;
            $doctorList=$doctor_obj->getDoctorList($hospitalId,$branchId,$departmentId);

            $result['Success']='Success';
            $result['doctorList']=$doctorList;
            return response()->json($result,200);
        }catch(\Throwable $th){
            $result['Success']='failure';
            $result['Message']=$th->getMessage();
            return response()->json($result,200);
        }
    }  
    public function getUnAssignedPatientDoctor(Request $request,$hospitalId,$branchId){
        try{
            $doctor_obj =new AssignDoctor;
            $patientList=$doctor_obj->getUnAssignedPatient($hospitalId,$branchId);
            $doctor_obj = new doctor;
            $doctorList = $doctor_obj->getDoctorByHospital($hospitalId,$branchId);

            $result['Success']='Success';
            $result['patientList']=$patientList;
            $result['doctorList']=$doctorList;
            return response()->json($result,200);
        }catch(\Throwable $th){
            $result['Success']='failure';
            $result['Message']=$th->getMessage();
            return response()->json($result,200);
        }
    }  
    
    public function addAssignDoctor(Request $request)
    {
        try{
            $result=array();
            DB::beginTransaction();
            $validate=Validator::make($request->all(), [
                'patientId'=>'required',
                'doctorId'=>'required',
                'userId'=>'required'
            ]);
            if($validate->fails()){
                $result['ShowModal']=1;
                $result['Success']='Failure';
                $result['Message']="Validation failed. Please fill the required field marked as *";
                return response()->json($result,200);
            }
            $assign_obj=new AssignDoctor;
            $assign_result=$assign_obj->addAssignDoctor($request);
            $id=$assign_result->id;
            if($id<=0){
                $result['ShowModal']=1;
                $result['Success']='Failure';
                $result['Message']="Please try again or contact support team.";
            }
            $result['ShowModal']=1;
            $result['Success']='Success';
            $result['Message']="Doctor assigned successfully";
            DB::commit();
            return response()->json($result,200);
        }catch(\Throwable $th){
            $result['ShowModal']=1;
            $result['Success']='failure';
            $result['Message']=$th->getMessage();
            return response()->json($result,200);
        }
    }
    public function getAllAssignedPatient(Request $request)
    {
        try{
            $pagination['page']=(isset($request->page) && !empty($request->page)) ?$request->page : 1;
            $pagination['size']=(isset($request->size) && !empty($request->size)) ?$request->size : 10;
            $pagination['sorters_field']=(isset($request->sorters[0]['field']) && !empty($request->sorters[0]['field'])) ?$request->sorters[0]['field'] : "assign_doctors.created_date";
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

            $assignDoctor_obj = new AssignDoctor;
            $assignDoctorList=$assignDoctor_obj->getAllAssignedPatient($decrpt_hospitalId,$decrpt_branchId,$pagination);
            
            $result['last_page']=$assignDoctorList['last_page'];
            $result['data']=$assignDoctorList['assignDoctorList'];
            return response()->json($result,200);
        }catch(\Throwable $th){
            $result['Success']='failure';
            $result['Message']=$th->getMessage();
            return response()->json($result,200);
        }
    }
    public function deleteAssignDoctor(Request $request,$id,$userId){
        try{
            $doctor_obj = new AssignDoctor;
            $doctorDetails=$doctor_obj->deleteAssignDoctorById($id,$userId);
            $result['Success']='Success';
            $result['ShowModal']= 1;
            $result['doctorDetails']=$doctorDetails;
            return response()->json($result,200);
        }catch(\Throwable $th){
            $result['Success']='failure';
            $result['Message']=$th->getMessage();
            return response()->json($result,200);
        }
    } 
    public function showAssignDoctorEdit(Request $request,$id){
        try{
            $doctor_obj = new AssignDoctor;
            $assignDetails=$doctor_obj->getAssignDoctorById($id);

            if($assignDetails!=null){
                $doctor_obj = new doctor;
                $assignDetails->doctorList = $doctor_obj->getDoctorByHospital($assignDetails->hospitalId,$assignDetails->branchId);
            }
            else{
                $doctorList=null;
            }

            return view('pages.editAssignDoctor')->with('AssignDetails', $assignDetails);
        }catch(\Throwable $th){
            return Redirect::back()->withErrors($th->getMessage());
        }
    }
    public function updateAssignDoctor(Request $request)
    {
        try{
            $result=array();
            DB::beginTransaction();
            $validateUser=Validator::make($request->all(), [
                'doctorId'=>'required',
            ]);
            if($validateUser->fails()){
                $result['ShowModal']=1;
                $result['Success']='Failure';
                $result['Message']="Validation failed. Please fill the required field marked as *";
                return response()->json($result,200);
            }
            $doctor_obj = new AssignDoctor;
            $doctors = $doctor_obj->updateAssignDoctor($request); 

            $result['ShowModal']=1;
            $result['Success']='Success';
            $result['Message']="Doctor updated successfully";
            DB::commit();
            return response()->json($result,200);
        }catch(\Throwable $th){
            $result['ShowModal']=1;
            $result['Success']='failure';
            $result['Message']=$th->getMessage();
            return response()->json($result,200);
        }
    }
}
