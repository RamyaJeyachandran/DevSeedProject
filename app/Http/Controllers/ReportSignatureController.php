<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Models\ReportSignature;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class ReportSignatureController extends Controller
{
    
    public function index()
    {
        return View("pages.ReportSignature");
    }
    public function getAllSignature(Request $request)
    {
        try{
            $pagination['page']=(isset($request->page) && !empty($request->page)) ?$request->page : 1;
            $pagination['size']=(isset($request->size) && !empty($request->size)) ?$request->size : 10;
            $pagination['sorters_field']=(isset($request->sorters[0]['field']) && !empty($request->sorters[0]['field'])) ?$request->sorters[0]['field'] : "report_signatures.created_date";
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

            $sign_obj = new ReportSignature;
            $signatureList=$sign_obj->getAllSignature($decrpt_hospitalId,$decrpt_branchId,$pagination);
            
            $result['last_page']=$signatureList['last_page'];
            $result['data']=$signatureList['reportSignatureList'];
            return response()->json($result,200);
        }catch(\Throwable $th){
            $result['Success']='failure';
            $result['Message']=$th->getMessage();
            return response()->json($result,200);
        }
    }
    public function addReportSignature(Request $request)
    {
        try{
            $result=array();
            $validateUser=Validator::make($request->all(), [
                'doctorLeftId'=>'required',
                'leftSignId'=>'required',
                'doctorRightId'=>'required',
                'rightSignId'=>'required',
                'doctorcenterId'=>'required',
                'centerSignId'=>'required',
            ]);
            if($validateUser->fails()){
                $result['ShowModal']=1;
                $result['Success']='Failure';
                $result['Message']="Validation failed. Please fill the required field marked as *";
                return response()->json($result,200);
            }

            $report_obj = new ReportSignature;
            if((isset($request->reportSignId) && !empty($request->reportSignId)))
            {
                //Check Dupliate sign -- Begin
                $chkSign=$report_obj->checkSignDuplicateById($request);
                
                if($chkSign==1){
                    $result['ShowModal']=1;
                    $result['Success']='Report Signature already exists';
                    return response()->json($result,200);
                }
                $reportSign =  $report_obj->updateReportSignature($request); 

                $result['ShowModal']=1;
                $result['Success']='Success';
                $result['Message']="Report signature updated successfully";
                return response()->json($result,200);
            //Check Dupliate sign-- Begin
            }else{
                //Check Dupliate sign -- Begin
                $chkSign=$report_obj->checkSignDuplicate($request);
                if($chkSign==1){
                    $result['ShowModal']=1;
                    $result['Success']='Report Signature already exists';
                    return response()->json($result,200);
                }
            //Check Dupliate sign-- Begin
                $reportSign =  $report_obj->addReportSignature($request); 
                $reportId=$reportSign->id;
                
                if($reportId>0){
                    $result['ShowModal']=1;
                    $result['Success']='Success';
                    $result['Message']="Report signature created successfully";
                    return response()->json($result,200);
                }else{
                    $result['ShowModal']=1;
                    $result['Success']='Failure';
                    $result['Message']="Report signature creation failed";
                    return response()->json($result,200);
                }
            }
        }catch(\Throwable $th){
            $result['ShowModal']=1;
            $result['Success']='failure';
            $result['Message']=$th->getMessage();
            return response()->json($result,200);
        }
    }
    public function updateDefaultSignature(Request $request,$userId,$reportSignId,$isDefault)
    {
        try{
            $result=array();
            $user_obj = new User;
            $decrypt_userId=$user_obj->getDecryptedId($userId);
            $decrypt_reportSignId=$user_obj->getDecryptedId($request->reportSignId);

            $report_obj = new ReportSignature;
            $is_default=($isDefault=='on'?1:0);
            $report = $report_obj->updateDefaultSignature($decrypt_userId,$decrypt_reportSignId,$is_default); 

            $result['ShowModal']=1;
            $result['Success']='Success';
            $result['Message']="Default signature has set successfully";
            return response()->json($result,200);
        }catch(\Throwable $th){
            $result['ShowModal']=1;
            $result['Success']='failure';
            $result['Message']=$th->getMessage();
            return response()->json($result,200);
        }
    }
    public function getReportSignByHospital(Request $request,$hospitalId,$branchId)
    {
        try{
            $result=array();
            $user_obj = new User;
            $decrypt_hospital=$user_obj->getDecryptedId($hospitalId);
            $decrypt_branchId=$user_obj->getDecryptedId($branchId);

            $report_obj = new ReportSignature;
            $reportSignList = $report_obj->getReportSignByHospitalId($decrypt_hospital,$decrypt_branchId); 

            $result['Success']='Success';
            $result['Message']="Fetched successfully";
            $result['data']=$reportSignList;
            return response()->json($result,200);
        }catch(\Throwable $th){
            $result['Success']='failure';
            $result['Message']=$th->getMessage();
            return response()->json($result,200);
        }
    }
}
