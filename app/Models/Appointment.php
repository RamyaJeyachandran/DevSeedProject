<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Carbon\Carbon;
use config\constants;


class Appointment extends Model
{
    public $timestamps = false;
    use HasFactory;
    protected $table = 'appointments';
    protected $fillable = [
        'patientId',
        'appointmentDate',
        'appointmentTime',
        'doctorId',
        'reason',
        'status',
        'hospitalId',
        'branchId',
        'is_active',
        'created_by',
        'updated_by'
    ];

    public static function addAppointment(Request $request,$patientId,$doctorId,$hospitalId,$branchId,$userId)
    {
        $appointmentDate = Carbon::parse($request->appointmentDate);
        $appointment_date = $appointmentDate->format('Y-m-d H:i:s');

        $branchId=$branchId==0?NULL:$branchId;

        return static::create(
            [
             'appointmentDate'=>$appointment_date,
             'appointmentTime' => $request->appointmentTime,
             'patientId'=>$patientId,
             'doctorId'=>$doctorId,
             'reason'=>$request->reason,
             'hospitalId'=>$hospitalId,
             'branchId'=>$branchId,
             'created_by'=>$userId
            ]
        );
    }
    public static function updateAppointment(Request $request,$appointmentId,$doctorId,$userId)
    {
        $status=$request->status==0?'Created':$request->status;
        $appointmentDate = Carbon::parse($request->appointmentDate);
        return static::where('id',$appointmentId)->update(
            [
             'appointmentDate'=>$appointmentDate,
             'appointmentTime' => $request->appointmentTime,
             'doctorId'=>$doctorId,
             'reason'=>$request->reason,
             'status'=>$status,
             'updated_by'=>$userId
            ]
        );
    }
    public static function deleteAppointment($id,$userId)
    {
        $user = new User;
        $updated_by=$user->getDecryptedId($userId);
        $appointmentId=$user->getDecryptedId($id);

        return static::where('id',$appointmentId)->update(
            [
             'status'=>"Deleted",
             'is_active'=>0,
             'updated_by'=>$updated_by
            ]
        );
    }
    public static function getAllAppointment($hospitalId,$branchId,$pagination,$type)
    {
        $skip=$pagination['page'] ==1 ?0:(($pagination['page'] * $pagination['size'])-$pagination['size']);
        if($pagination['filters_field']=='hcNo' || $pagination['filters_field']=='patientName' || $pagination['filters_field']=='phoneNo')
        {
            $pagination['filters_field']=($pagination['filters_field']=='patientName'?'name':$pagination['filters_field']);
            $wherePatient_sts="patients.is_active=1 ".($hospitalId==0?"":" and patients.hospitalId=".$hospitalId).($branchId==0?"":" and patients.branchId=".$branchId)." and patients.".$pagination['filters_field']." ".$pagination['filters_type'].($pagination['filters_type']=='like'?" '%":"").$pagination['filters_value'].($pagination['filters_type']=='like'?"%'":"");
            $where_sts="appointments.is_active=1 ".($hospitalId==0?"":" and appointments.hospitalId=".$hospitalId).($branchId==0?"":" and appointments.branchId=".$branchId);
            $whereDoctor_sts="doctors.is_active=1";
        }
        else if($pagination["filters_field"]== "doctorName"){
            $where_sts="appointments.is_active=1 ".($hospitalId==0?"":" and appointments.hospitalId=".$hospitalId).($branchId==0?"":" and appointments.branchId=".$branchId);
            $whereDoctor_sts="doctors.is_active=1 and doctors.name ".$pagination['filters_type'].($pagination['filters_type']=='like'?" '%":"").$pagination['filters_value'].($pagination['filters_type']=='like'?"%'":"");
            $wherePatient_sts="patients.is_active=1 ".($hospitalId==0?"":" and patients.hospitalId=".$hospitalId).($branchId==0?"":" and patients.branchId=".$branchId);
        }
        else{
            $wherePatient_sts="patients.is_active=1 ".($hospitalId==0?"":" and patients.hospitalId=".$hospitalId).($branchId==0?"":" and patients.branchId=".$branchId);
            $whereDoctor_sts="doctors.is_active=1";
            $where_sts="appointments.is_active=1 ".($hospitalId==0?"":" and appointments.hospitalId=".$hospitalId).($branchId==0?"":" and appointments.branchId=".$branchId)." ".(($pagination['filters_field'] =="" || $pagination['filters_value']=="")?"":" and ".$pagination['filters_field']." ".$pagination['filters_type']." ".($pagination['filters_field']=='appointmentDate'?"'".Carbon::parse($pagination['filters_value'])->toDateString()."'":$pagination['filters_value']).($pagination['filters_field']=='appointmentDate'?"":"%'"));
        }
        if($type==2){
            $where_sts=$where_sts." and appointments.appointmentDate ='".Carbon::parse(now())->toDateString()."'";
        }
        $appointmentList['where_sts']=$where_sts;
        $appointmentList['appointmentList']=DB::table('appointments')->selectRaw("concat(appointmentDate, ' ', appointmentTime) as appointmentDateTime,HEX(AES_ENCRYPT(appointments.id,UNHEX(SHA2('".config('constant.mysql_custom_encrypt_key')."',512)))) as id,HEX(AES_ENCRYPT(appointments.patientId,UNHEX(SHA2('".config('constant.mysql_custom_encrypt_key')."',512)))) as patientId,HEX(AES_ENCRYPT(appointments.doctorId,UNHEX(SHA2('".config('constant.mysql_custom_encrypt_key')."',512)))) as doctorId,appointments.appointmentDate,appointments.appointmentTime,appointments.status,appointments.reason,COALESCE(departments.name,'') as departmentName,patients.profileImage,patients.hcNo,patients.name as patientName,patients.phoneNo,patients.email,patients.address,doctors.name as doctorName,CASE WHEN appointments.status ='Started' THEN 'success' WHEN appointments.status ='Finished'  THEN 'danger' WHEN appointments.status ='Created'  THEN 'info' WHEN appointments.status ='Pending'  THEN 'pending' WHEN appointments.status ='ReSchedule'  THEN 'gray-600' WHEN appointments.status ='OnGoing'  THEN 'dark' WHEN appointments.status ='Cancelled'  THEN 'warning' ELSE 'primary' END as statusColor")
                                    ->join('doctors', function($join) use ($whereDoctor_sts)
                                        {
                                            $join->on('doctors.id', '=', 'appointments.doctorId')
                                            ->whereRaw($whereDoctor_sts);
                                        })
                                    ->join('patients', function($join) use ($wherePatient_sts)
                                        {
                                        $join->on('patients.id', '=', 'appointments.patientId')
                                            ->whereRaw($wherePatient_sts);
                                        })
                                    ->leftJoin('departments','departments.id','=','doctors.departmentId')
                                    ->whereRaw($where_sts)
                                    ->skip($skip)->take($pagination['size']) //pagination
                                    ->orderBy($pagination['sorters_field'],$pagination['sorters_dir']) 
                                   ->get();
                                   
        $lastPage=DB::table('appointments')->whereRaw($where_sts)->count();

        $appointmentList['last_page']=ceil($lastPage/$pagination['size']);

        return $appointmentList;
    }
    public static function getAppointmentById($id)
    {
        $user = new User;
        $appointmentId=$user->getDecryptedId($id);
        return DB::table('appointments')->selectRaw("HEX(AES_ENCRYPT(appointments.id,UNHEX(SHA2('".config('constant.mysql_custom_encrypt_key')."',512)))) as id,HEX(AES_ENCRYPT(appointments.patientId,UNHEX(SHA2('".config('constant.mysql_custom_encrypt_key')."',512)))) as patientId,HEX(AES_ENCRYPT(appointments.doctorId,UNHEX(SHA2('".config('constant.mysql_custom_encrypt_key')."',512)))) as doctorId,appointments.appointmentDate,appointments.appointmentTime,appointments.status,appointments.reason,COALESCE(doctors.departmentId,0) as departmentId,patients.gender,patients.profileImage,patients.hcNo,patients.name as patientName,patients.phoneNo,patients.email,patients.address,HEX(AES_ENCRYPT(appointments.hospitalId,UNHEX(SHA2('".config('constant.mysql_custom_encrypt_key')."',512)))) as hospitalId,HEX(AES_ENCRYPT(appointments.branchId,UNHEX(SHA2('".config('constant.mysql_custom_encrypt_key')."',512)))) as branchId,patients.bloodGroup,patients.martialStatus,patients.spouseName,patients.spousePhnNo")
                                        ->join('doctors','doctors.id','=','appointments.doctorId')
                                        ->join('patients','patients.id','=','appointments.patientId')
                                        ->where('appointments.id',$appointmentId)
                                    ->first();
    }
    public static function setAppointmentStatus($request)
    {
        $user = new User;
        $appointmentId=$user->getDecryptedId($request->appointmentId);
        $updated_by=$user->getDecryptedId($request->userId);
        return static::where('id',$appointmentId)->update(
            [
             'status'=>$request->status,
             'updated_by'=>$updated_by
            ]
        );
    }
    public static function getPatientAppointmentInfo($id){
        $user = new User;
        $appointmentId=$user->getDecryptedId($id);

        return DB::table('appointments')->selectRaw("HEX(AES_ENCRYPT(appointments.id,UNHEX(SHA2('".config('constant.mysql_custom_encrypt_key')."',512)))) as id,HEX(AES_ENCRYPT(appointments.patientId,UNHEX(SHA2('".config('constant.mysql_custom_encrypt_key')."',512)))) as patientId,HEX(AES_ENCRYPT(appointments.doctorId,UNHEX(SHA2('".config('constant.mysql_custom_encrypt_key')."',512)))) as doctorId,appointments.appointmentDate,appointments.appointmentTime,appointments.status,appointments.reason,COALESCE(doctors.departmentId,0) as departmentId,patients.gender,patients.profileImage,patients.hcNo,patients.name as patientName,patients.phoneNo,patients.email,patients.address,patients.spouseName,patients.spousePhnNo,patients.bloodGroup,patients.martialStatus,patients.patientWeight,patients.patientHeight,doctors.name as doctorName,COALESCE(departments.name,'') as departmentName")
                                        ->join('doctors','doctors.id','=','appointments.doctorId')
                                        ->leftJoin('departments','departments.id','=','doctors.departmentId')
                                        ->join('patients','patients.id','=','appointments.patientId')
                                        ->where('appointments.id',$appointmentId)
                                    ->first();
    }
    public static function getReportPatientWise($request)  
    {
        $user = new User;
        $hospitalId=($request->hospitalId==NULL?$request->hospitalId:$user->getDecryptedId($request->hospitalId));
        $branchId=($request->branchId==NULL?$request->branchId:$user->getDecryptedId($request->branchId));
        $patientId=$user->getDecryptedId($request->patientId);
        $doctorId=$user->getDecryptedId($request->doctorId);

        $dateRange="";
        $where_patientSts="patients.is_active=1 ";
        $where_doctorSts="doctors.is_active=1 ";
        $where_sts="appointments.is_active=1 ".($hospitalId==0?"":" and appointments.hospitalId=".$hospitalId).($branchId==0?"": " and appointments.branchId=".$branchId);

        if($request->reportId==1)
        {
            $dateRange=explode("-",$request->dateRange);
            $where_sts= $where_sts. " and ( appointments.appointmentDate >= '".Carbon::parse($dateRange[0])->toDateString()."' and appointments.appointmentDate <= '".Carbon::parse($dateRange[1])->toDateString()."' )";
        }
        else if($request->reportId== 2)
        {
            $where_sts= $where_sts. " and DATE_FORMAT(appointments.appointmentDate, '%Y-%m') = '".$request->monthYear."'";
        }
        else if($request->reportId== 3)
        {
            $where_sts= $where_sts." and DATE_FORMAT(appointments.appointmentDate, '%Y') = '".$request->yearId ."'";
        }
        if($patientId>0)
        {
            $where_patientSts= $where_patientSts." and patients.id=".$patientId;
        }
        if($doctorId>0)
        {
            $where_doctorSts= $where_doctorSts." and doctors.id=".$doctorId;
        }
        $patientDetails=DB::table('appointments')->selectRaw("ROW_NUMBER() OVER(ORDER BY appointments.id) as sNo,TIME_FORMAT(appointmentTime, '%h:%i %p') as appointmentTime,appointmentDate ,appointments.reason,patients.name as patientName,patients.hcNo,patients.phoneNo,patients.email,patients.gender,patients.martialStatus,CONCAT(patients.address,' ',patients.city,' ',patients.state) as address,doctors.name as doctorName,doctors.doctorCodeNo,patients.spouseName,doctors.phoneNo as doctorPhoneNo,doctors.email as doctorEmail,departments.name as department,doctors.designation")
                                            ->join('doctors', function ($join) use ($where_doctorSts)  {
                                                $join->on('doctors.id', '=', 'appointments.doctorId')
                                                     ->whereRaw($where_doctorSts);
                                            })
                                            ->leftJoin('departments','departments.id','=','doctors.departmentId')
                                            ->join('patients', function ($join) use ($where_patientSts) {
                                                $join->on('patients.id', '=', 'appointments.patientId')
                                                     ->whereRaw($where_patientSts);
                                            })
                                            ->whereRaw($where_sts)
                                            // ->orderBy('patients.name','asc')
                                            ->orderBy('appointments.appointmentDate','desc')
                                            ->orderBy('appointments.appointmentTime','desc')
                                            ->get();
        return $patientDetails;
    }
}