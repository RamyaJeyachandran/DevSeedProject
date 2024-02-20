<?php

namespace App\Http\Controllers;

use URL;
use App\Models\User;
use config\constants;
use App\Models\doctor;
use App\Models\Patient;
use App\Models\Appointment;
use App\Models\MixedTables;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class AppointmentController extends Controller
{
    public function index(Request $request)
    {
        if($request->session()->get('isSetDefault')==1){
            $patient_obj = new Patient;
            $patientList = $patient_obj->getPatientByHospitalId($request->session()->get('hospitalId'),$request->session()->get('branchId'));
            return View("pages.addAppointment")->with('patientList',$patientList);
        }
        else{
            return redirect()->action(
                [DashboardController::class, 'getDefaultSetting'], ['id' =>  $request->session()->get('userId')]
            );
        }
    }
    public function searchIndex()
    {
        return View("pages.searchAppointment");
    }
    public function showToday()
    {
        return View("pages.todayAppointment");
    }
    
    public function getPatientInfo(Request $request,$hcNo,$hospitalId,$branchId)
    {
        try{
            $patient_obj = new Patient;
            $patientDetails=$patient_obj->getPatientByHcNo($hcNo,$hospitalId,$branchId);

            $result['Success']='Success';
            $result['patientDetails']=$patientDetails;
            return response()->json($result,200);
        }catch(\Throwable $th){
            $result['Success']='failure';
            $result['Message']= config('constant.error_msg');
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
                //Check Phone No --- BEGIN
                $chkPhoneNo=$patient_obj->checkPhoneNo($request->phoneNo,$hospitalId,$branchId);
                if($chkPhoneNo!=NULL){
                    $result['ShowModal']=1;
                    $result['Success']='Phone No already exists.';
                    $result['Message']="Phone No registered patient number : ".$chkPhoneNo->hcNo;
                    return response()->json($result,200);
                }
              //Check Phone No --- END
                $url = request()->getSchemeAndHttpHost();//URL::to("/");
                $profileImage =$url .config('constant.imageStoreLocation'). config('constant.doctor_default_profileImage');

                $hcNo=$patient_obj->generateHcNo($hospitalId);
                $addPatient=$patient_obj->addAppointmentPatient($request,$hcNo,$hospitalId,$branchId,$userId,$profileImage);
                if($addPatient==NULL){
                    DB::rollback();
                    $result['ShowModal']=1;
                    $result['Success']='Failure';
                    $result['Message']="Please enter the valid patient information";
                    return response()->json($result,200);
                }
                $patientId=$addPatient->id;
                $patientMsg='Patient created successfully. Patient Registered Number : '.$hcNo;
            }
             /*------------------------------ Add unregistered patient END --------------------*/
            $appointment_obj=new Appointment;

            if($request->tabNo==1){
                $patientId=$user->getDecryptedId($request->patientId);
                 //Check patient appointment on that day
                $chkPatientAppointment=$appointment_obj->checkPatientAppointment($request->appointmentDate,$patientId,$doctorId,0);
                if($chkPatientAppointment!=NULL){
                    DB::rollback();
                    $result['ShowModal']=1;
                    $result['Success']='Appointment already exists.';
                    $result['Message']="Patient appointment time : ".$chkPatientAppointment->appointmentTime;
                    return response()->json($result,200);
                }
            }
            if($patientId==0){
                DB::rollback();
                    $result['ShowModal']=1;
                    $result['Success']='Failure';
                    $result['Message']="Please enter the valid patient information";
                    return response()->json($result,200);
            }
            //Check doctor schedule on that day
            $chkDoctorSchedule=$appointment_obj->checkDoctorAppointment($request->appointmentDate,$request->appointmentTime,$doctorId,0);
            if($chkDoctorSchedule!=NULL){
                DB::rollback();
                $result['ShowModal']=1;
                $result['Success']='Doctor have another appointment at that time.';
                $result['Message']="Appointment Interval 10 minutes.Please choose another time.";
                return response()->json($result,200);
            }
           
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
            $appointmentList=$appointment_obj->getAllAppointment($decrpt_hospitalId,$decrpt_branchId,$pagination,$request->type);
            
            $result['last_page']=$appointmentList['last_page'];
            $result['data']=$appointmentList['appointmentList'];
            return response()->json($result,200);
        }catch(\Throwable $th){
            $result['Success']='failure';
            $result['Message']=$th->getMessage();
            return response()->json($result,200);
        }
    }
    public function getPatientAppointmentInfo(Request $request,$id)
    {
        try{
            $appointment_obj = new Appointment;
            $appointmentDetails=$appointment_obj->getPatientAppointmentInfo($id);

            $result['Success']='Success';
            $result['appointmentDetails']=$appointmentDetails;
            return response()->json($result,200);
        }catch(\Throwable $th){
            $result['Success']='failure';
            $result['Message']=$th->getMessage();
            return response()->json($result,200);
        }
    }
    public function deleteAppointment(Request $request,$id,$userId)
    {
        try{
            $appointment_obj = new Appointment;
            $appointmentDetails=$appointment_obj->deleteAppointment($id,$userId);

            $result['Success']='Success';
            $result['ShowModal']=1;
            $result['appointmentDetails']=$appointmentDetails;
            return response()->json($result,200);
        }catch(\Throwable $th){
            $result['Success']='failure';
            $result['Message']=$th->getMessage();
            return response()->json($result,200);
        }
    }
    public function showEdit(Request $request,$id,$type){
        try{
            $appointment_obj = new Appointment;
            $appointmentDetails=$appointment_obj->getAppointmentById($id);

            $mixedTable = new MixedTables;
            $appointmentDetails->departmentList = $mixedTable->getDepartment();
            $appointmentDetails->statusList =  $mixedTable->getConsantValue(config('constant.appointmentStatusTableId'));

            $doctor_obj =new doctor;
            $appointmentDetails->doctorList=$doctor_obj->getDoctorList($appointmentDetails->hospitalId,$appointmentDetails->branchId,$appointmentDetails->departmentId);
            $appointmentDetails->type=$type;
            return view('pages.editAppointment')->with('appointmentDetails', $appointmentDetails);
        }catch(\Throwable $th){
            $result['Success']='failure';
            $result['Message']=$th->getMessage();
            return response()->json($result,200);
        }
    }
    public function updateAppointment(Request $request)
    {
        try{
            $result=array();
            DB::beginTransaction();
            $validateUser=Validator::make($request->all(), [
                'appointmentDate'=>'required',
                'appointmentTime'=>'required',
                'doctorId'=>'required',
                'reason'=>'required',
                'patientId'=>'required',
                'appointmentId'=>'required',
            ]);
            if($validateUser->fails()){
                $result['ShowModal']=1;
                $result['Success']='Failure';
                $result['Message']="Validation failed. Please fill the required field marked as *";
                return response()->json($result,200);
            }
            $user = new User;
            $userId=$user->getDecryptedId($request->userId);
            $doctorId=$user->getDecryptedId($request->doctorId);
            $patientId=$user->getDecryptedId($request->patientId);
            $appointmentId=$user->getDecryptedId($request->appointmentId);

            if($patientId==0 || $appointmentId==0){
                DB::rollback();
                    $result['ShowModal']=1;
                    $result['Success']='Failure';
                    $result['Message']="Invalid patient information";
                    return response()->json($result,200);
            }
            $appointment_obj=new Appointment;
                //Check doctor schedule on that day
            $chkDoctorSchedule=$appointment_obj->checkDoctorAppointment($request->appointmentDate,$request->appointmentTime,$doctorId,$appointmentId);
            if($chkDoctorSchedule!=NULL){
                DB::rollback();
                $result['ShowModal']=1;
                $result['Success']='Doctor have another appointment at that time.';
                $result['Message']="Appointment Interval 10 minutes.Please choose another time.";
                $result['data']=$chkDoctorSchedule;
                return response()->json($result,200);
            }

            $appointment_res=$appointment_obj->updateAppointment($request,$appointmentId,$doctorId,$userId);
            DB::commit();
            $result['Success']='Success';
            $result['Message']='Appointment Updated successfully';
            $result['ShowModal']= 1;
            return response()->json($result,200);
        }catch(\Throwable $th){
            DB::rollback();
            $result['ShowModal']=1;
            $result['Success']='failure';
            $result['Message']=$th->getMessage();
            return response()->json($result,200);
        }
    }
    public function updateAppointmentStatus(Request $request)
    {
        try{
            $appointment_obj = new Appointment;
            $appointment_obj->setAppointmentStatus($request);

            $result['Success']='Success';
            $result['Message']="Appointment Status Updated Successfully";
            return response()->json($result,200);
        }catch(\Throwable $th){
            $result['Success']='failure';
            $result['Message']=$th->getMessage();
            return response()->json($result,200);
        }
    }
}
