<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\doctor;
use App\Models\Patient;
use App\Models\PrePostWash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

class PrePostWashController extends Controller
{
    public function index(Request $request)
    {
        if($request->session()->get('isSetDefault')==1){
            return view('pages.addPrePostAnanlysis');
        }
        else{
            return redirect()->action(
                [DashboardController::class, 'getDefaultSetting'], ['id' =>  $request->session()->get('userId')]
            );
        }
    }
    public function searchIndex()
    {
        return view('pages.searchPrePostAnalysis');
    }
    public function savePrePostWash(Request $request)
    {
        try {
            $result = array();
            DB::beginTransaction();
            $validateUser = Validator::make($request->all(), [
                'patientId' => 'required',
                'doctorId'  => 'required',
            ]);
            $chkValidation=($request->patientId==0 || $request->doctorId== 0)?0:1;
            if ($validateUser->fails() || $chkValidation== 0) {
                $result['ShowModal'] = 1;
                $result['Success'] = 'Failure';
                $result['Message'] = "Validation failed. Please fill the required field marked as *";
                return response()->json($result, 200);
            }
            $prePostWash_obj = new PrePostWash;
            $prePost =  $prePostWash_obj->addPrePostWash($request);
            $id=$prePost->id;
            if($id<=0){
                DB::rollback();
                $result['ShowModal'] = 1;
                $result['Success'] = 'Failure';
                $result['Message'] ="Please try again";
                return response()->json($result, 200);
            }
            $user = new User;
            $encrypt_id = $user->getEncryptedId($id);

            
            $result['ShowModal'] = 1;
            $result['Success'] = 'Success';
            $result['semenId'] = $encrypt_id;
            $result['Message'] = "Pre & Post wash analysis created successfully";

            DB::commit();
            return response()->json($result, 200);
        } catch (\Throwable $th) {
            DB::rollback();
            $result['ShowModal'] = 1;
            $result['Success'] = 'failure';
            $result['Message'] = $th->getMessage();
            return response()->json($result, 200);
        }
    }
    public function getAllprePostWash(Request $request)
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

            $prePostWash_obj=new PrePostWash;
            $prePostWashList=$prePostWash_obj->getAllPrePostWash($decrpt_hospitalId,$decrpt_branchId,$pagination);
            
            $result['last_page']=$prePostWashList['last_page'];
            $result['data']=$prePostWashList['prePostWashList'];
            return response()->json($result,200);
        }catch(\Throwable $th){
            $result['Success']='failure';
            $result['Message']=$th->getMessage();
            return response()->json($result,200);
        }
    }
    public function deletePrePostWash(Request $request,$id,$userId)
    {
        try {
            $PrePostWash_obj=new PrePostWash;
            $PrePostWash_obj->deletePrePostWashById($id,$userId);

            $result['Success']='Success';
            $result['ShowModal']=1;
            return response()->json($result, 200);
        } catch (\Throwable $th) {
            $result['Success'] = 'failure';
            $result['Message'] = $th->getMessage();
            return response()->json($result, 200);
        }
    }
    public function showEdit($id)
    {
        try {
            $id_orignal = "AES_DECRYPT(UNHEX('" . $id . "'), UNHEX(SHA2('" . config('constant.mysql_custom_encrypt_key') . "',512)))";
            $prePost_obj = new PrePostWash;
            $prePostDetails = $prePost_obj->getPrePostWashById($id_orignal);

            $doctor_obj=new doctor;
            $prePostDetails->doctorList=$doctor_obj->getDoctorByHospital($prePostDetails->hospitalId,$prePostDetails->branchId);
           
            return view('pages.editPrePostAnalysis')->with('prePostDetails', $prePostDetails);
        } catch (\Throwable $th) {
            $result['Success'] = 'failure';
            $result['Message'] = $th->getMessage();
            return response()->json($result, 200);
        }
    }
    public function updatePrePostAnalysis(Request $request)
    {
        try {
            $result = array();
            DB::beginTransaction();
            $validateUser = Validator::make($request->all(), [
                'patientId' => 'required',
                'doctorId'  => 'required',
            ]);
            $chkValidation=($request->patientId==0 || $request->doctorId== 0)?0:1;
            if ($validateUser->fails() || $chkValidation== 0) {
                $result['ShowModal'] = 1;
                $result['Success'] = 'Failure';
                $result['Message'] = "Validation failed. Please fill the required field marked as *";
                return response()->json($result, 200);
            }

            $prePost_obj = new PrePostWash;
            $prePost_obj->updatePrePostAnalysis($request);

            $result['ShowModal'] = 1;
            $result['Success'] = 'Success';
            $result['Message'] = "Pre & Post Analysis Report Updated successfully";

            DB::commit();
            return response()->json($result, 200);
        } catch (\Throwable $th) {
            $result['ShowModal'] = 1;
            $result['Success'] = 'failure';
            $result['Message'] = $th->getMessage();
            return response()->json($result, 200);
        }
    }
    public function showPrint(Request $request,$id)
    {
        try{
            $user = new User;
            $id_orignal = $user->getDecryptedId($id);

            $analysis_obj = new PrePostWash;
            $analysisDetails=$analysis_obj->getPrePostWashByIdForPrint($id_orignal);
            return view('pages.reportPrePost')->with('analysisDetails', $analysisDetails);
        }catch(\Throwable $th){
            return Redirect::back()->withErrors($th->getMessage());
        }
    }
    public function getPatientSequenceNo(Request $request,$patientId)
    {
        try {
            $user = new User;
            $id_orignal = $user->getDecryptedId($patientId);

            $patient_obj = new Patient;
            $patientDetails=$patient_obj->getPatientById($id_orignal);

            $PrePostWash_obj=new PrePostWash;
            $seqNo=$PrePostWash_obj->getPatientSequenceCount($id_orignal);
            $seqNo=$seqNo+1;

            $result['Success'] = 'Success';
            $result['seqNo'] = $seqNo;
            $result['patientDetails'] = $patientDetails;
            return response()->json($result, 200);
        } catch (\Throwable $th) {
            $result['Success'] = 'failure';
            $result['Message'] = $th->getMessage();
            return response()->json($result, 200);
        }
    }
    public function getPrePostPatientDoctor(Request $request,$hospitalId,$branchId)
    {
        try {
            $PrePostWash_obj = new PrePostWash;
            $patientList = $PrePostWash_obj->getPrePostPatientDoctor($hospitalId,$branchId);

            $doctor_obj = new doctor;
            $doctorList = $doctor_obj->getDoctorByHospital($hospitalId,$branchId);
                
            $result['patientList'] = $patientList;
            $result['doctorList'] = $doctorList;
                $result['Success'] = 'Success';
                return response()->json($result, 200);
        } catch (\Throwable $th) {
            $result['Success'] = 'failure';
            $result['Message'] = $th->getMessage();
            return response()->json($result, 200);
        }
    }
}
