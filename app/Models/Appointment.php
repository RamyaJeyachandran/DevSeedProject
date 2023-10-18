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
    public static function updateAppointment(Request $request)
    {
        $user = new User;
        $userId=$user->getDecryptedId($request->userId);
        $decryp_doctorId=$user->getDecryptedId($request->doctorId);
        $decryp_appointmentId=$user->getDecryptedId($request->appointmentId);

        $appointmentDate = Carbon::parse($request->appointmentDate);
        return static::where('id',$decryp_appointmentId)->update(
            [
             'appointmentDate'=>$appointmentDate,
             'appointmentTime' => $request->appointmentTime,
             'doctorId'=>$decryp_doctorId,
             'reason'=>$request->reason,
             'status'=>$request->status,
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
    public static function getAllAppointment($hospitalId,$branchId,$pagination)
    {
        $skip=$pagination['page'] ==1 ?0:(($pagination['page'] * $pagination['size'])-$pagination['size']);
        if($pagination['filters_field']=='hcNo')
        {
            $wherePatient_sts="patients.is_active=1 ".($hospitalId==0?"":" and patients.hospitalId=".$hospitalId).($branchId==0?"":" and patients.branchId=".$branchId)." and patients.hcNo like '%".$pagination['filters_value']."%'";
            $where_sts="appointments.is_active=1 ".($hospitalId==0?"":" and appointments.hospitalId=".$hospitalId).($branchId==0?"":" and appointments.branchId=".$branchId);
        }
        else{
            $wherePatient_sts="patients.is_active=1 ".($hospitalId==0?"":" and patients.hospitalId=".$hospitalId).($branchId==0?"":" and patients.branchId=".$branchId);
            $where_sts="appointments.is_active=1 ".($hospitalId==0?"":" and appointments.hospitalId=".$hospitalId).($branchId==0?"":" and appointments.branchId=".$branchId)." ".(($pagination['filters_field'] =="" || $pagination['filters_value']=="")?"":" and ".$pagination['filters_field']." ".$pagination['filters_type']." '".$pagination['filters_value']."%'");
        }
        

        $appointmentList['appointmentList']=DB::table('appointments')->selectRaw("concat(appointmentDate, ' ', appointmentTime) as appointmentDateTime,HEX(AES_ENCRYPT(appointments.id,UNHEX(SHA2('".config('constant.mysql_custom_encrypt_key')."',512)))) as id,HEX(AES_ENCRYPT(appointments.patientId,UNHEX(SHA2('".config('constant.mysql_custom_encrypt_key')."',512)))) as patientId,HEX(AES_ENCRYPT(appointments.doctorId,UNHEX(SHA2('".config('constant.mysql_custom_encrypt_key')."',512)))) as doctorId,appointments.appointmentDate,appointments.appointmentTime,appointments.status,appointments.reason,COALESCE(departments.name,'') as departmentName,patients.profileImage,patients.hcNo,patients.name as patientName,patients.phoneNo,patients.email,patients.address,doctors.name as doctorName")
                                    ->join('doctors','doctors.id','=','appointments.doctorId')
                                    // ->join('patients','patients.id','=','appointments.patientId')
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
        return DB::table('appointments')->selectRaw("HEX(AES_ENCRYPT(appointments.id,UNHEX(SHA2('".config('constant.mysql_custom_encrypt_key')."',512)))) as id,HEX(AES_ENCRYPT(appointments.patientId,UNHEX(SHA2('".config('constant.mysql_custom_encrypt_key')."',512)))) as patientId,HEX(AES_ENCRYPT(appointments.doctorId,UNHEX(SHA2('".config('constant.mysql_custom_encrypt_key')."',512)))) as doctorId,appointments.appointmentDate,appointments.appointmentTime,appointments.status,appointments.reason,COALESCE(doctors.departmentId,0) as departmentId,patients.gender,patients.profileImage,patients.hcNo,patients.name as patientName,patients.phoneNo,patients.email,patients.address")
                                        ->join('doctors','doctors.id','=','appointments.doctorId')
                                        ->join('patients','patients.id','=','appointments.patientId')
                                        ->where('id',$appointmentId)
                                    ->first();
    }
    public static function setAppointmentStatus($status,$id,$userId)
    {
        $user = new User;
        $appointmentId=$user->getDecryptedId($id);
        $updated_by=$user->getDecryptedId($userId);
        return static::where('id',$appointmentId)->update(
            [
             'status'=>$status,
             'updated_by'=>$updated_by
            ]
        );
    }
}
