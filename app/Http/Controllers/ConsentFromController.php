<?php

namespace App\Http\Controllers;

use App\Models\ConsentFrom;
use App\Models\patientConsentForm;
use App\Models\Patient;
use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use config\constants;

class ConsentFromController extends Controller
{
    public function index(Request $request,$hcNo=0){
        try{
            return view('pages.consentForm')->with('hcNo', $hcNo);
        }catch(\Throwable $th){
            return view('pages.error')->with('errorMsg',$th->getMessage())->with('errorNo','401');
        }
    }
    public function searchIndex()
    {
        return view('pages.SearchConsentForm');
    }
    public function viewIndex()
    {
        return view('pages.viewConsentForm');
    }
    public function getFormList(Request $request,$hospitalId,$branchId,$hcNo){
        try{
            $patientDetails=NULL;
            $selectedFormDetails=NULL;
            if($hcNo>0){
                $patient_obj = new Patient;
                $patientDetails=$patient_obj->getPatientByHcNo($hcNo,$hospitalId,$branchId);
                if($patientDetails!=NULL){
                    $consent_obj = new patientConsentForm;
                    $selectedFormDetails=$consent_obj->getSelectedConsentForm($patientDetails->patientId);
                }else{
                    $result['Success']='No record found';
                    $result['ShowModal']=1;
                    $result['Message']="Invalid Registration Number";
                    return response()->json($result,200);
                }
            }
            $consent_obj = new ConsentFrom;
            $consentList=$consent_obj->getConsentFormList($hospitalId,$branchId);
            
            $result['Success']='Success';
            $result['ShowModal']=1;
            $result['consentList']=$consentList;
            $result['patientDetails']=$patientDetails;
            $result['selectedForm']=$selectedFormDetails;
            return response()->json($result,200);
        }catch(\Throwable $th){
            $result['Success']='failure';
            $result['Message']=$th->getMessage();
            return response()->json($result,200);
        }
    } 
    public function saveConsentForm(Request $request){
        try{
            DB::beginTransaction();
            $user = new User;
            $consent_obj = new patientConsentForm;

            $patientId=$user->getDecryptedId($request->patientId);
            $userId=$user->getDecryptedId($request->userId);
            $consentFormList=explode(",", $request->consentFormList);
            $deleteForm=$consent_obj->deletePatientConsentForm($patientId,$userId);

            foreach ($consentFormList as $formList) {
                $formId=$user->getDecryptedId($formList);  
                $chkForm=$consent_obj->checkPatientConsentForm($patientId,$formId,$userId);

                if($chkForm==0){
                    $saveForm=$consent_obj->saveConsentForm($patientId,$formId,$userId);
                    if($saveForm==NULL){
                        DB::rollback();
                        $result['ShowModal']=1;
                        $result['Success']='failure';
                        $result['Message']='Error occurred during creation';
                        return response()->json($result,200);
                    }
                }                                                                    
            }
            DB::commit();

            $result['ShowModal']=1;
            $result['Success']='Success';
            $result['Message']="Successfully saved the patient consent form";
            // $result['consentList']=$formId;
            return response()->json($result,200);
        }catch(\Throwable $th){
            DB::rollback();
            $result['ShowModal']=1;
            $result['Success']='failure';
            $result['Message']=$th->getMessage();
            return response()->json($result,200);
        }
    }
    public function getPatientConsentDetails(Request $request){
        try{
           
            $pagination['page']=(isset($request->page) && !empty($request->page)) ?$request->page : 1;
            $pagination['size']=(isset($request->size) && !empty($request->size)) ?$request->size : 10;
            $pagination['sorters_field']=(isset($request->sorters[0]['field']) && !empty($request->sorters[0]['field'])) ?$request->sorters[0]['field'] : "pcf.created_date";
            $pagination['sorters_dir']=(isset($request->sorters[0]['dir']) && !empty($request->sorters[0]['dir'])) ?$request->sorters[0]['dir'] : "desc";

            $pagination['filters_field']=(isset($request->filters[0]['field']) && !empty($request->filters[0]['field'])) ?$request->filters[0]['field'] : "";
            $pagination['filters_type']=(isset($request->filters[0]['type']) && !empty($request->filters[0]['type'])) ?$request->filters[0]['type'] : "";
            $pagination['filters_value']=(isset($request->filters[0]['value']) && !empty($request->filters[0]['value'])) ?$request->filters[0]['value'] :"";

            $hospitalId=(isset($request->hospitalId) && !empty($request->hospitalId)) ?$request->hospitalId : NULL;
            $branchId=(isset($request->branchId) && !empty($request->branchId)) ?$request->branchId : NULL;

             //Decrypt --- BEGIN
             $user = new User;
             $decrpt_hospitalId=($hospitalId==NULL?$hospitalId:$user->getDecryptedId($hospitalId));
             $decrpt_branchId=($branchId==NULL?$branchId:$user->getDecryptedId($branchId));
             //Decrypt --- END
             $patient_obj = new patientConsentForm;
             $patientConsentList=$patient_obj->getAllPatientConsentDetails($decrpt_hospitalId,$decrpt_branchId,$pagination);

            $result['Success']='Success';
            $result['last_page']=$patientConsentList['last_page'];
            $result['data']=$patientConsentList['patientConsentList'];
            return response()->json($result,200);
        }catch(\Throwable $th){
            $result['Success']='failure';
            $result['Message']=$th->getMessage();
            return response()->json($result,200);
        }
    } 
        
}
