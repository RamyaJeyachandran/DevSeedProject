<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Patient;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use config\constants;
use URL;

class AppointmentController extends Controller
{
    public function index()
    {
        return View("pages.addAppointment");
    }
    public function searchIndex()
    {
        return View("pages.searchAppointment");
    }
    public function getPatientInfo(Request $request,$hcNo,$hospitalId,$branchId)
    {
        try{
            $patient_obj = new Patient;
            $patientDetails=$patient_obj->getPatientByHcNo($hcNo,$hospitalId,$branchId);

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
    public function addAppointment(Request $request)
    {
        try{
            $result=array();
            DB::beginTransaction();
            $validateUser=Validator::make($request->all(), [
                'appointmentDate'=>'required',
                'appointmentTime'=>'required',
                'doctorId'=>'required',
                'reason'=>'required',
            ]);
            $validatoin_chk=1;
            if($request->tabNo==1){
                $validatoin_chk=($request->patientId==NULL?1:0);
            }else if($request->tabNo==2){
                $validatePatient=Validator::make($request->all(), [
                    'patientName'=>'required',
                    'phoneNo'=>'required',
                    'email'=>'required',
                ]);
                $validatoin_chk= $validatePatient->fails();
            }
            if($validateUser->fails() || $validatoin_chk==1){
                $result['ShowModal']=1;
                $result['Success']='Failure';
                $result['Message']="Validation failed. Please fill the required field marked as *";
                $result=json_encode($request);
                return response()->json($result,200);
            }
            $user = new User;
            $userId=$user->getDecryptedId($request->userId);
            $hospitalId=$user->getDecryptedId($request->hospitalId);
            $branchId=$user->getDecryptedId($request->branchId);
            $doctorId=$user->getDecryptedId($request->doctorId);
            
            $patientId=0;
            $patientMsg='';
            /*------------------------------ Add unregistered patient BEGIN --------------------*/
            if($request->tabNo==2){
                $patient_obj=new Patient;
                $url = URL::to("/");
                $profileImage =$url ."/". config('constant.doctor_default_profileImage');

                $hcNo=$patient_obj->generateHcNo($hospitalId);
                $addPatient=$patient_obj->addAppointmentPatient($request,$hcNo,$hospitalId,$branchId,$userId,$profileImage);
                if($addPatient==NULL){
                    DB::rollback();
                    $result['ShowModal']=1;
                    $result['Success']='Failure';
                    $result['Message']="Please enter the valid patient information";
                    $result=json_encode($request);
                    return response()->json($result,200);
                }
                $patientId=$addPatient->id;
                $patientMsg='Patient created successfully. Patient Registered Number : '.$hcNo;
            }
             /*------------------------------ Add unregistered patient END --------------------*/
            if($request->tabNo==1){
                $patientId=$user->getDecryptedId($request->patientId);
            }

            if($patientId==0){
                DB::rollback();
                    $result['ShowModal']=1;
                    $result['Success']='Failure';
                    $result['Message']="Please enter the valid patient information";
                    $result=json_encode($request);
                    return response()->json($result,200);
            }

            $appointment_obj=new Appointment;
            $appointment_res=$appointment_obj->addAppointment($request,$patientId,$doctorId,$hospitalId,$branchId,$userId);
            $id=$appointment_res->id;
            DB::commit();
            $result['Success']='Success';
            $result['Message']='Appointment created successfully';
            $result['patientMsg']=$patientMsg;
            
            $result['ShowModal']= 1;
            $result['patientDetails']=$id;
            return response()->json($result,200);
        }catch(\Throwable $th){
            DB::rollback();
            $result['ShowModal']=1;
            $result['Success']='failure';
            $result['Message']=$th->getMessage();
            return response()->json($result,200);
        }
    }
    public function getAllAppointment(Request $request)
    {
        try{
            $pagination['page']=(isset($request->page) && !empty($request->page)) ?$request->page : 1;
            $pagination['size']=(isset($request->size) && !empty($request->size)) ?$request->size : 10;
            $pagination['sorters_field']=(isset($request->sorters[0]['field']) && !empty($request->sorters[0]['field'])) ?$request->sorters[0]['field'] : "appointmentDate";
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

            $appointment_obj=new Appointment;
            $appointmentList=$appointment_obj->getAllAppointment($decrpt_hospitalId,$decrpt_branchId,$pagination);
            
            $result['last_page']=$appointmentList['last_page'];
            $result['data']=$appointmentList['appointmentList'];
            return response()->json($result,200);
        }catch(\Throwable $th){
            $result['Success']='failure';
            $result['Message']=$th->getMessage();
            return response()->json($result,200);
        }
    }
}
