<?php

namespace App\Models;

use Carbon\Carbon;
use config\constants;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\JoinClause;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class HospitalSettings extends Model
{

    public $timestamps = false;
    use HasFactory;
    protected $table = 'hospitalSettings';
    protected $fillable = [
        'logo',
        'hospitalName',
        'address',
        'phoneNo',
        'email',
        'inChargePerson',
        'inChargePhoneNo',
        'is_subscribed',
        'is_active',
        'created_by',
        'updated_by'
    ];

    public static function addHospitalSettings(Request $request,$logo)
    {
        $user = new User;
        $userId=$user->getDecryptedId($request->userId);

        return static::create(
            [
                'hospitalName' => $request->hospitalName,
                'address' => $request->address,
                'phoneNo' => $request->phoneNo,
                'email' => $request->email,
                'inChargePerson' => $request->inChargePerson,
                'inChargePhoneNo' => $request->inChargePhoneNo,
                'created_by' => $userId,
                'logo'=>$logo
            ]
        );
    }
    public static function updateHospitalSettings(Request $request,$logo)
    {
        $hospitalId = "AES_DECRYPT(UNHEX('" . $request->hospitalId . "'), UNHEX(SHA2('" . config('constant.mysql_custom_encrypt_key') . "',512)))";
        $where_sts = "id=" . $hospitalId;
        $user = new User;
        $userId=$user->getDecryptedId($request->userId);
        if($logo==""){
            return static::whereRaw($where_sts)->update(
                [
                    'hospitalName' => $request->hospitalName,
                    'address' => $request->address,
                    'phoneNo' => $request->phoneNo,
                    'email' => $request->email,
                    'inChargePerson' => $request->inChargePerson,
                    'inChargePhoneNo' => $request->inChargePhoneNo,
                    'updated_by' => $userId,
                ]
            );
        }else{
            return static::whereRaw($where_sts)->update(
                [
                    'hospitalName' => $request->hospitalName,
                    'address' => $request->address,
                    'phoneNo' => $request->phoneNo,
                    'email' => $request->email,
                    'inChargePerson' => $request->inChargePerson,
                    'inChargePhoneNo' => $request->inChargePhoneNo,
                    'updated_by' => $userId,
                    'logo'=>$logo
                ]
            );
        }
    }
    public function getAllHospitalSettings($pagination)
    {
        $skip=$pagination['page'] ==1 ?0:(($pagination['page'] * $pagination['size'])-$pagination['size']);
        $where_sts="is_active=1  ".(($pagination['filters_field'] =="" || $pagination['filters_value']=="")?"":" and ".$pagination['filters_field']." ".$pagination['filters_type']." '".$pagination['filters_value']."%'");
       
        $hospitalSettingsList['hospitalSettingsList'] = DB::table('hospitalSettings')->selectRaw("logo,HEX(AES_ENCRYPT(id,UNHEX(SHA2('".config('constant.mysql_custom_encrypt_key')."',512)))) as id,hospitalName,address,phoneNo,email,inChargePerson,inChargePhoneNo,IF(is_subscribed=0,'No','Yes') as is_subscribed,IF(is_active=0,'In Active','Active') as status")
                                                            ->whereRaw($where_sts)
                                                            ->skip($skip)->take($pagination['size']) //pagination
                                                            ->orderBy($pagination['sorters_field'],$pagination['sorters_dir']) 
                                                             ->get();
        $lastPage=DB::table('hospitalSettings')->whereRaw($where_sts)->count();
        $hospitalSettingsList['last_page']=ceil($lastPage/$pagination['size']);
        return $hospitalSettingsList;
    }
    public function getHospitalSettingsById($id)
    {
        $where_sts = "id=" . $id;
        $hospitalDetails = DB::table('hospitalSettings')->selectRaw("logo,hospitalName,address,phoneNo,email,inChargePerson,inChargePhoneNo,IF(is_subscribed=0,'No','Yes') as is_subscribed,HEX(AES_ENCRYPT(id,UNHEX(SHA2('".config('constant.mysql_custom_encrypt_key')."',512)))) as hospitalId")
            ->whereRaw($where_sts)
            ->first();
        return $hospitalDetails;
    }

    public function getHospitalByEmailOrPhoneNo($request)
    {
        $email=$request->email;
        $phoneNo=$request->phoneNo;
        $hospitalDetailsList = DB::table('hospitalSettings')
            ->select("hospitalName")
            ->where(function ($q) use ($email, $phoneNo) {
                $q
                    ->Where("phoneNo", "=", $phoneNo)
                    ->orWhere("email", "=", $email);
            })->first();
        return $hospitalDetailsList;
    }
    public function deleteHospitalSettingsById($id, $userId)
    {
        $hospitalId = "AES_DECRYPT(UNHEX('" . $id . "'), UNHEX(SHA2('" . config('constant.mysql_custom_encrypt_key') . "',512)))";
        $where_sts = "id=" . $hospitalId;
        $user = new User;
        $updated_by=$user->getDecryptedId($userId);

        return static::whereRaw($where_sts)->update(
            [
                'is_active' => 0,
                'updated_by' => $updated_by
            ]
        );
    }
    public static function checkPhoneNoById($request){
        $email=$request->email;
        $phoneNo=$request->phoneNo;
        $hospitalId = "AES_DECRYPT(UNHEX('" . $request->hospitalId . "'), UNHEX(SHA2('" . config('constant.mysql_custom_encrypt_key') . "',512)))";
        $where_sts="is_active=1 and id <>".$hospitalId;
        $phoneNoList=DB::table('hospitalSettings')->select('hospitalName')->whereRaw($where_sts) ->where(function ($q) use ($email, $phoneNo) {
            $q
                ->Where("phoneNo", "=", $phoneNo)
                ->orWhere("email", "=", $email);
        })->first();
         return $phoneNoList; 
    }
    public static function hospitalActiveList(){
        $hospitalDetails = DB::table('hospitalSettings')->selectRaw("hospitalName as name,HEX(AES_ENCRYPT(id,UNHEX(SHA2('".config('constant.mysql_custom_encrypt_key')."',512)))) as id")
            ->where("is_active",1)
            ->get();
        return $hospitalDetails;
    }
    public static function getAdminDashboard(){
        $dashboard['total_hospital'] = DB::table('hospitalsettings')->selectRaw('count(id) as cnt')->where('is_active',1)->pluck('cnt');
        $dashboard['total_branch'] = DB::table('hospitalbranch')->selectRaw('count(hospitalbranch.id) as cnt')
                                                                ->join('hospitalsettings', function($join)
                                                                {
                                                                    $join->on('hospitalsettings.id', '=', 'hospitalbranch.hospitalId')
                                                                    ->where('hospitalsettings.is_active','=',1);
                                                                })
                                                                ->where('hospitalbranch.is_active',1)->pluck('cnt');
        $dashboard['total_doctor'] = DB::table('doctors')->selectRaw('count(doctors.id) as cnt')
                                                                ->join('hospitalsettings', function($join)
                                                                {
                                                                    $join->on('hospitalsettings.id', '=', 'doctors.hospitalId')
                                                                    ->where('hospitalsettings.is_active','=',1);                                                     
                                                                })
                                                                ->where('doctors.is_active',1)->pluck('cnt');
        $dashboard['total_patient'] = DB::table('patients')->selectRaw('count(patients.id) as cnt')
                                                                ->join('hospitalsettings', function($join)
                                                                {
                                                                    $join->on('hospitalsettings.id', '=', 'patients.hospitalId')
                                                                    ->where('hospitalsettings.is_active','=',1);                                                   
                                                                })
                                                                ->where('patients.is_active',1)->pluck('cnt');

        $doctor_sub_table= DB::table('doctors')->selectRaw('hospitalId,COUNT(id) as total_doctors')->where('is_active',1)->groupBy('hospitalId');
        $patient_sub_table= DB::table('patients')->selectRaw('hospitalId,COUNT(id) as total_patients')->where('is_active',1)->groupBy('hospitalId');

        $dashboard['hospitalWise'] = DB::table('hospitalsettings')
                                                ->selectRaw('hospitalsettings.hospitalName,hospitalsettings.logo,COUNT(hospitalbranch.id) as total_branches,Max(total_doctors) as total_doctors,Max(total_patients) AS total_patients')
                                                                ->leftJoin('hospitalbranch', function($join)
                                                                {
                                                                    $join->on('hospitalbranch.hospitalId', '=', 'hospitalsettings.id')
                                                                    ->where('hospitalbranch.is_active','=',1);                                                   
                                                                })
                                                                ->joinSub($doctor_sub_table, 'doctor_sub', function (JoinClause $join)
                                                                {
                                                                    $join->on('hospitalsettings.id', '=', 'doctor_sub.hospitalId');
                                                                })
                                                                ->joinSub($patient_sub_table, 'patient_sub', function (JoinClause $join)
                                                                {
                                                                    $join->on('hospitalsettings.id', '=', 'patient_sub.hospitalId');
                                                                })
                                                                ->where('hospitalsettings.is_active',1)
                                                                ->groupBy('hospitalsettings.hospitalName','hospitalsettings.logo')
                                                                ->get();
        
        return $dashboard;
    }
    public static function getHospitalDashboard($hospitalId){
        $doctor_sub_table= DB::table('doctors')->selectRaw('hospitalId,COUNT(id) as total_doctors')->where([['is_active','=',1],['hospitalId','=',$hospitalId]])
                                                ->groupBy('hospitalId');
        $patient_sub_table= DB::table('patients')->selectRaw('hospitalId,COUNT(id) as total_patients')->where([['is_active','=',1],['hospitalId','=',$hospitalId]])
                                                ->groupBy('hospitalId');

        $dashboard['hospitalWiseTotal']= DB::table('hospitalsettings')->selectRaw("COUNT(hospitalbranch.id) as total_branches,MAX(total_doctors) AS total_doctors,MAX(total_patients) AS total_patients")
                                                    ->leftJoin("hospitalbranch", "hospitalbranch.hospitalId","=","hospitalsettings.id")
                                                    ->joinSub($doctor_sub_table, 'doctor_sub', function (JoinClause $join)
                                                                {
                                                                    $join->on('hospitalsettings.id', '=', 'doctor_sub.hospitalId');
                                                                })
                                                    ->joinSub($patient_sub_table, 'patient_sub', function (JoinClause $join)
                                                                {
                                                                    $join->on('hospitalsettings.id', '=', 'patient_sub.hospitalId');
                                                                })
                                                    ->where([['hospitalsettings.is_active','=',1],['hospitalsettings.id','=',$hospitalId]])
                                                    ->groupBy('hospitalsettings.id')->first();


        $doctor_sub_table1= DB::table('doctors')->selectRaw('hospitalId,branchId,COUNT(id) as total_doctors')->where([['is_active','=',1],['hospitalId','=',$hospitalId]])
                                                    ->groupBy('hospitalId','branchId');
        $patient_sub_table1= DB::table('patients')->selectRaw('hospitalId,branchId,COUNT(id) as total_patients')->where([['is_active','=',1],['hospitalId','=',$hospitalId]])
                                                    ->groupBy('hospitalId','branchId');
        $dashboard['branchWise']=DB::table('hospitalbranch')->selectRaw("hospitalbranch.branchName,hospitalbranch.logo,MAX(total_doctors) AS total_doctors,MAX(total_patients) AS total_patients")
                                                        ->joinSub($doctor_sub_table1, 'doctor_sub', function (JoinClause $join)
                                                        {
                                                            $join->on('hospitalbranch.id', '=', 'doctor_sub.branchId')
                                                                ->on('hospitalbranch.hospitalId', '=','doctor_sub.hospitalId');
                                                        })
                                                        ->joinSub($patient_sub_table1, 'patient_sub', function (JoinClause $join)
                                                        {
                                                            $join->on('hospitalbranch.id', '=', 'patient_sub.branchId')
                                                                    ->on('hospitalbranch.hospitalId', '=', 'patient_sub.hospitalId');
                                                        })
                                                ->where([['hospitalbranch.is_active','=',1],['hospitalbranch.hospitalId','=',$hospitalId]])
                                                ->groupBy('hospitalbranch.id','hospitalbranch.branchName','hospitalbranch.logo')->get();
        return $dashboard;
    }
    public static function getBranchDashboard($branchId){
        $patient_sub_table= DB::table('patients')->selectRaw('hospitalId,branchId,COUNT(id) as total_patients')
                                                ->where([['is_active','=',1],['branchId','=',$branchId]])
                                                    ->groupBy('hospitalId','branchId');
        $appointment_sub_table= DB::table('appointments')->selectRaw('hospitalId,branchId,COUNT(id) as total_appointments')
                                                    ->where([['is_active','=',1],['branchId','=',$branchId]])
                                                        ->groupBy('hospitalId','branchId');
        
        $dashboard['branchWiseTotal']= DB::table('hospitalbranch')->selectRaw("COUNT(DISTINCT(doctors.id)) AS total_doctors,COALESCE(MAX(total_patients),0) AS total_patients,COALESCE(MAX(total_appointments),0) AS total_appointments")
                                                ->leftJoin("doctors",function (JoinClause $join){
                                                    $join->on('hospitalbranch.hospitalId', '=', 'doctors.hospitalId')
                                                        ->on('hospitalbranch.id', '=','doctors.branchId')
                                                        ->where('doctors.is_active',1);
                                                })
                                                ->leftJoinSub($patient_sub_table, 'patient_sub', function (JoinClause $join)
                                                {
                                                    $join->on('hospitalbranch.hospitalId', '=', 'patient_sub.hospitalId')
                                                        ->on('hospitalbranch.id', '=','patient_sub.branchId');
                                                })
                                                ->leftJoinSub($appointment_sub_table, 'appointment_sub', function (JoinClause $join)
                                                {
                                                    $join->on('hospitalbranch.hospitalId', '=', 'appointment_sub.hospitalId')
                                                        ->on('hospitalbranch.id', '=','appointment_sub.branchId');
                                                })
                                            ->where([["hospitalbranch.is_active","=",1],["hospitalbranch.id","=", $branchId]])
                                            ->groupBy("hospitalbranch.hospitalId","hospitalbranch.id")->first();

        $appointment_sub_table= DB::table('appointments')->selectRaw('doctorId,COUNT(DISTINCT(patientId)) as total_patient,COUNT(id) AS total_appointment')
                                                ->where([['is_active','=',1],['branchId','=',$branchId]])
                                                    ->groupBy('doctorId');
    
        $dashboard['doctorWiseTotal']= DB::table('doctors')->selectRaw("doctors.name,doctors.profileImage,COALESCE(MAX(total_patient),0) AS total_patient,COALESCE(MAX(total_appointment),0) AS total_appointment")
                                                ->leftJoin("patients",function (JoinClause $join){
                                                    $join->on('patients.hospitalId', '=', 'doctors.hospitalId')
                                                    ->on('patients.branchId', '=','doctors.branchId')
                                                    ->where('patients.is_active',1);
                                                })
                                                ->leftJoinSub($appointment_sub_table, 'appointment_sub', function (JoinClause $join)
                                                {
                                                    $join->on('doctors.hospitalId', '=', 'appointment_sub.doctorId');
                                                })
                                                ->where([["doctors.is_active","=",1],["doctors.branchId","=",$branchId]])
                                                ->groupBy("doctors.name","doctors.profileImage")
                                                ->get();
        
        return $dashboard;
    }
    public static function getDoctorDashboard($doctorId){
        $appointment_sub_table= DB::table('appointments')->selectRaw('doctorId,COUNT(DISTINCT(patientId)) as total_patient,COUNT(id) AS today_appointment')
                                                ->where([['is_active','=',1],['doctorId','=',$doctorId],['appointmentDate','=',Carbon::parse(now())->toDateString()]])
                                                    ->groupBy('doctorId');
        $dashboard['appointmentTotal']= DB::table('appointments')->selectRaw("1 as type,HEX(AES_ENCRYPT(appointments.doctorId,UNHEX(SHA2('".config('constant.mysql_custom_encrypt_key')."',512)))) as doctorId,COUNT(DISTINCT(appointments.patientId)) as total_patient,COUNT(appointments.id) AS total_appointment,COALESCE(MAX(today_appointment),0) AS today_appointment")
                                                ->where([['appointments.is_active','=',1],['appointments.doctorId','=',$doctorId]])
                                                ->leftJoinSub($appointment_sub_table, 'appointment_sub', function (JoinClause $join)
                                                {
                                                    $join->on('appointments.doctorId', '=', 'appointment_sub.doctorId');
                                                })
                                                ->groupBy('appointments.doctorId')
                                                ->first();
        $dashboard['appointmentDetails']= DB::table('appointments')->selectRaw('row_number() OVER (PARTITION BY  appointments.id) as sNo,appointments.appointmentTime,patients.name,appointments.status,patients.phoneNo,patients.email,appointments.reason')
                                                                    ->join('patients','patients.id','=','appointments.patientId')
                                                                   ->where([['appointments.is_active','=',1],['appointments.doctorId','=',$doctorId]])
                                                                   ->orderBy('appointments.appointmentTime','asc')
                                                                   ->get();
        if($dashboard['appointmentTotal']==null){
            $select_query="SELECT 1 as type,HEX(AES_ENCRYPT(".$doctorId.",UNHEX(SHA2('".config('constant.mysql_custom_encrypt_key')."',512)))) as doctorId,0 as total_patient,0 as today_appointment";
            $result=DB::select($select_query);
            $dashboard['appointmentTotal']=$result[0];
        }
        return $dashboard;
    }
    public static function getAppointmentStatus($doctorId){
        $appointmentStatus= DB::table('appointments')->selectRaw("status,COUNT(DISTINCT(id)) AS statusCount,CASE WHEN appointments.status ='Started' THEN '#84cc16' WHEN appointments.status ='Finished'  THEN '#dc2626' WHEN appointments.status ='Created'  THEN '#06b6d4' WHEN appointments.status ='Pending'  THEN '#f97316' WHEN appointments.status ='ReSchedule'  THEN '#64748b' WHEN appointments.status ='OnGoing'  THEN '#1e293b' WHEN appointments.status ='Cancelled'  THEN '#facc15' ELSE '#1E40AF' END as statuscolor")
                                                                  ->where([['appointments.is_active','=',1],['appointments.doctorId','=',$doctorId]]) 
                                                                  ->groupBy('status')
                                                                  ->get()
                                                                  ->toArray();
        return $appointmentStatus;
    }
}