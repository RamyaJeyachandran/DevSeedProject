<?php

namespace App\Http\Controllers;

use App\Models\donorBank;
use URL;
use App\Models\User;
use App\Models\doctor;
use App\Models\Patient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

class RefferedByController extends Controller
{
    public function index()
    {
        return View("pages.refferedBy");
    }
    public function donorBank()
    {
        return View("pages.donorBank");
    }
    
    public function showRefferedBy(Request $request,$id){
        try{            
            $id_orignal="AES_DECRYPT(UNHEX('".$id."'), UNHEX(SHA2('".config('constant.mysql_custom_encrypt_key')."',512)))";
            $patient_obj = new Patient;
            $patientDetails=$patient_obj->getPatientById($id_orignal);

            $doctor_obj = new doctor;
            $patientDetails->refferedByList = $doctor_obj->getDoctorByHospital($patientDetails->dHopsitalId,$patientDetails->dBranchId);           
           
            $donor_obj=new donorBank;
            $patientDetails->donorBankList=$donor_obj->getDonorBankByHospital($patientDetails->dHopsitalId,$patientDetails->dBranchId);

            return view('pages.addRefferedBy')->with('patientDetails', $patientDetails);
        }catch(\Throwable $th){
            return Redirect::back()->withErrors($th->getMessage());
        }
    }
    public function updatePatient(Request $request)
    {
        try{
            $result=array();
            DB::beginTransaction();
            $validateUser=Validator::make($request->all(), [
                'refferedByDoctorId'=>'required'
            ]);
            if($validateUser->fails()){
                $result['ShowModal']=1;
                $result['Success']='Failure';
                $result['Message']="Validation failed. Please fill the required field marked as *";
                return response()->json($result,200);
            }
            $patient_obj = new Patient;
            
            $patients = $patient_obj->updatePatientRefferedBy($request); 

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
   
}