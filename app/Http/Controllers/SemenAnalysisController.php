<?php

namespace App\Http\Controllers;

use App\Models\User;

use App\Models\doctor;
use App\Models\Patient;
use App\Models\MixedTables;
use Illuminate\Http\Request;
use App\Models\semenanalysis;
use App\Models\DoctorSignature;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;


class SemenAnalysisController extends Controller
{
    public function index()
    {
        return view('pages.addSemenAnalysis');
    }
    public function searchIndex()
    {
        return view('pages.searchSemenAnalysis');
    }
    public function showPrint(Request $request,$id)
    {
        try{
            $id_orignal = "AES_DECRYPT(UNHEX('" . $id . "'), UNHEX(SHA2('" . config('constant.mysql_custom_encrypt_key') . "',512)))";
            $analysis_obj = new semenanalysis;
            $analysisDetails=$analysis_obj->getSemenAnalysisByIdForPrint($id_orignal);
            

            return view('pages.reportSA')->with('analysisDetails', $analysisDetails);
        }catch(\Throwable $th){
            return Redirect::back()->withErrors($th->getMessage());
        }
    }
    public function getPatientDoctor(Request $request,$hospitalId,$branchId)
    {
        try {
            $patient_obj = new Patient;
            $patientList = $patient_obj->getPatientByHospitalId($hospitalId,$branchId);

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
    public function saveSemenAnalysis(Request $request)
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
            $semenanalysis_obj = new semenanalysis;
            $semenanalysis =  $semenanalysis_obj->addSemenAnalysis($request);
            $id=$semenanalysis->id;
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
            $result['Message'] = "Semen analysis created successfully";

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
    public function showEdit($id)
    {
        try {
            $id_orignal = "AES_DECRYPT(UNHEX('" . $id . "'), UNHEX(SHA2('" . config('constant.mysql_custom_encrypt_key') . "',512)))";
            $semenanalysis_obj = new semenanalysis;
            $semenanalysisDetails = $semenanalysis_obj->getSemenAnalysisById($id_orignal);

            $mixedTable = new MixedTables;
            $semenanalysisDetails->liquefactionList =  $mixedTable->getConsantValue(config('constant.liquefactionId'));
            $semenanalysisDetails->appearanceList = $mixedTable->getConsantValue(config('constant.appearanceId'));
            $semenanalysisDetails->viscosityList = $mixedTable->getConsantValue(config('constant.viscosityId'));
            $semenanalysisDetails->phList = $mixedTable->getConsantValue(config('constant.phId'));
            $semenanalysisDetails->abstinenceList = $mixedTable->getConsantValue(config('constant.abstinenceId'));
            $semenanalysisDetails->agglutinationList = $mixedTable->getConsantValue(config('constant.agglutinationId'));
            $semenanalysisDetails->clumpingList = $mixedTable->getConsantValue(config('constant.clumpingId'));
            $semenanalysisDetails->puscellsList = $mixedTable->getConsantValue(config('constant.pusCellsId'));

            $doctor_obj=new doctor;
            $semenanalysisDetails->doctorList=$doctor_obj->getDoctorByHospital($semenanalysisDetails->hospitalId,$semenanalysisDetails->branchId);

            $doctor_obj = new DoctorSignature;
            $semenanalysisDetails->signatureDetails=$doctor_obj->getDoctorSignatureByDoctorId($semenanalysisDetails->doctorId);

            return view('pages.editSemenAnalysis')->with('semenanalysisDetails', $semenanalysisDetails);
        } catch (\Throwable $th) {
            $result['Success'] = 'failure';
            $result['Message'] = $th->getMessage();
            return response()->json($result, 200);
        }
    }
    public function updateSemenAnalysis(Request $request)
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

            $semenanalysis_obj = new semenanalysis;
            $semenanalysis =  $semenanalysis_obj->updateSemenAnalysis($request);

            $result['ShowModal'] = 1;
            $result['Success'] = 'Success';
            $result['Message'] = "SemenAnalysis Report Updated successfully";

            DB::commit();
            return response()->json($result, 200);
        } catch (\Throwable $th) {
            $result['ShowModal'] = 1;
            $result['Success'] = 'failure';
            $result['Message'] = $th->getMessage();
            return response()->json($result, 200);
        }
    }
    public function getAllSemenAnalysis(Request $request)
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

            $semenanalysis_obj=new semenanalysis;
            $semenanalysis=$semenanalysis_obj->getAllSemenAnalysis($decrpt_hospitalId,$decrpt_branchId,$pagination);
            
            $result['last_page']=$semenanalysis['last_page'];
            $result['data']=$semenanalysis['SemenAnalysisList'];
            return response()->json($result,200);
        }catch(\Throwable $th){
            $result['Success']='failure';
            $result['Message']=$th->getMessage();
            return response()->json($result,200);
        }
    }
    public function deleteSemenAnalysis(Request $request,$id,$userId)
    {
        try {
            $semenanalysis_obj=new semenanalysis;
            $semenanalysisDetails=$semenanalysis_obj->deleteSemenAnalysisById($id,$userId);

            $result['Success']='Success';
            $result['ShowModal']=1;
            $result['appointmentDetails']=$semenanalysisDetails;
            return response()->json($result, 200);
        } catch (\Throwable $th) {
            $result['Success'] = 'failure';
            $result['Message'] = $th->getMessage();
            return response()->json($result, 200);
        }
    }
}
