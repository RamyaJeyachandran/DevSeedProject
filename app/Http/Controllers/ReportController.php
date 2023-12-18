<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Patient;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index()
    {
        return View("pages.patientCycleReport");
    }
    public function patientIndex()
    {
        return View("pages.PatientDetailledReport");
    }
    public function getReportPatientWise(Request $request)
    {
        try{
            $patient_obj=new Appointment;
            $patientDetails=$patient_obj->getReportPatientWise($request);
            $result['ShowModal']=1;
            $result['Success']='Success';
            $result['reportDetails']=$patientDetails;
            return response()->json($result,200);
        }catch(\Throwable $th){
            $result['Success']='failure';
            $result['Message']=$th->getMessage();
            return response()->json($result,200);
        }
    }
    public function getPatientDetailReport(Request $request)
    {
        try{
            $patient_obj=new Patient;
            $patientDetails=$patient_obj->getPatientDetailReport($request);
            $result['ShowModal']=1;
            $result['Success']='Success';
            $result['reportDetails']=$patientDetails;
            return response()->json($result,200);
        }catch(\Throwable $th){
            $result['Success']='failure';
            $result['Message']=$th->getMessage();
            return response()->json($result,200);
        }
    }
}
