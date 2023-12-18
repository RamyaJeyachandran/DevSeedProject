<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Http\Request;

class AssignDoctor extends Model
{
    public $timestamps = false;
    use HasFactory;
    protected $table = 'assign_doctors';
    use HasFactory;
    protected $fillable = [
        'patientId',
        'doctorId',
        'is_active',
        'created_by',
        'updated_by'
    ];
    public static function addAssignDoctor($request)
    {
        $user = new User;
        $userId=$user->getDecryptedId($request->userId);
        $patientId=$user->getDecryptedId($request->patientId);
        $doctorId=$user->getDecryptedId($request->doctorId);

        return static::create(
            [
             'patientId'=>$patientId,
             'doctorId'=>$doctorId,
             'created_by'=>$userId
            ]
        );
    }
    public static function getUnAssignedPatient($hospitalId,$branchId){
        $user = new User;
        $orignal_hospitalId=$hospitalId==0?$hospitalId:$user->getDecryptedId($hospitalId);
        $orignal_branchId=$branchId==0?null:$user->getDecryptedId($branchId);
        $where_sts="patients.is_active=1 ".($orignal_hospitalId==0 || $orignal_hospitalId==null ?"":" and patients.hospitalId=".$orignal_hospitalId).($orignal_branchId==0|| $orignal_branchId==null?"":" and patients.branchId=".$orignal_branchId);

       return DB::table('patients')->selectRaw("HEX(AES_ENCRYPT(patients.id,UNHEX(SHA2('".config('constant.mysql_custom_encrypt_key')."',512)))) as id,CONCAT(patients.name,'-',patients.hcNo) as name")
                                          ->leftJoin("assign_doctors","assign_doctors.patientId","=","patients.id")
                                          ->whereRaw($where_sts)
                                          ->whereNotIn('patients.id',DB::table('assign_doctors')->where('is_active',1)->pluck('patientId'))
                                          ->get();
    }
    public static function getAllAssignedPatient($hospitalId,$branchId,$pagination)
    {
        $skip=$pagination['page'] ==1 ?0:(($pagination['page'] * $pagination['size'])-$pagination['size']);
        $wherePatient_sts="patients.is_active=1 ".($hospitalId==0?"":" and patients.hospitalId=".$hospitalId).($branchId==0?"":" and patients.branchId=".$branchId);
        $whereDoctor_sts="doctors.is_active=1 ".($hospitalId==0?"":" and doctors.hospitalId=".$hospitalId).($branchId==0?"":" and doctors.branchId=".$branchId);

        if($pagination['filters_field']=='patientName' || $pagination['filters_field']=='hcNo' || $pagination['filters_field']=='patientPhoneNo')
        {
            $filters_field="";
            switch($pagination['filters_field'])
            {
                case 'patientName':
                    $filters_field="name";
                    break;
                case 'patientPhoneNo':
                    $filters_field="phoneNo";
                    break;
                default:
                    $filters_field=$pagination['filters_field'];
                    break;
            }
            if($filters_field!="")
            {
                $wherePatient_sts=$wherePatient_sts.(($filters_field=="" || $pagination['filters_value']=="")?"":" and patients.".$filters_field." ".$pagination['filters_type']." '".$pagination['filters_value'].($pagination['filters_type']=="like"?"%'":"'"));
            }
        }
        if($pagination['filters_field']=='doctorName' || $pagination['filters_field']=='doctorCodeNo' || $pagination['filters_field']=='doctorPhoneNo')
        {
            $filters_field="";
            switch($pagination['filters_field'])
            {
                case 'doctorName':
                    $filters_field="name";
                    break;
                case 'doctorPhoneNo':
                    $filters_field="phoneNo";
                    break;
                default:
                    $filters_field=$pagination['filters_field'];
                    break;
            }
            if($filters_field!="")
            {
                $whereDoctor_sts= $whereDoctor_sts.(($filters_field =="" || $pagination['filters_value']=="")?"":" and doctors.".$filters_field." ".$pagination['filters_type']." '".$pagination['filters_value'].($pagination['filters_type']=="like"?"%'":"'"));
            }
        }

        $assignDoctorList['assignDoctorList']=DB::table('assign_doctors')->selectRaw("HEX(AES_ENCRYPT(assign_doctors.id,UNHEX(SHA2('".config('constant.mysql_custom_encrypt_key')."',512)))) as id,patients.name as patientName,patients.hcNo,patients.profileImage as patientImage,patients.phoneNo as patientPhoneNo,doctors.name as doctorName,doctors.doctorCodeNo,doctors.phoneNo as doctorPhoneNo,doctors.profileImage as doctorImage")
                                             ->join('patients', function($join) use($wherePatient_sts)
                                                {
                                                    $join->on('patients.id', '=', 'assign_doctors.patientId')
                                                         ->whereRaw($wherePatient_sts);
                                                })
                                             ->join('doctors', function($join) use($whereDoctor_sts)
                                                {
                                                $join->on('doctors.id', '=', 'assign_doctors.doctorId')
                                                    ->whereRaw($whereDoctor_sts);
                                                })
                                                ->where('assign_doctors.is_active','=',1)
                                                ->skip($skip)->take($pagination['size']) //pagination
                                                ->orderBy($pagination['sorters_field'],$pagination['sorters_dir'])
                                                ->get();

        $lastPage=$assignDoctorList['assignDoctorList']->count();
        $assignDoctorList['last_page']=ceil($lastPage/$pagination['size']);
        
        return $assignDoctorList;
    }
    public function deleteAssignDoctorById($id,$userId)
    {
        $assignId="AES_DECRYPT(UNHEX('".$id."'), UNHEX(SHA2('".config('constant.mysql_custom_encrypt_key')."',512)))";
        $where_sts="id=".$assignId;
        $user = new User;
        $original_userId=$user->getDecryptedId($userId);
        
        return static::whereRaw($where_sts)->update(
            [
             'is_active'=>0,
             'updated_by'=>$original_userId
            ]
        );
    }   
    public function getAssignDoctorById($id)
    {
        $user = new User;
        $original_id=$user->getDecryptedId($id);

        $patientDetails=DB::table('assign_doctors')->selectRaw("patients.name,patients.hcNo,patients.phoneNo,patients.email,patients.profileImage,HEX(AES_ENCRYPT(doctors.id,UNHEX(SHA2('".config('constant.mysql_custom_encrypt_key')."',512)))) as doctorId,HEX(AES_ENCRYPT(doctors.hospitalId,UNHEX(SHA2('".config('constant.mysql_custom_encrypt_key')."',512)))) as hospitalId,HEX(AES_ENCRYPT(doctors.branchId,UNHEX(SHA2('".config('constant.mysql_custom_encrypt_key')."',512)))) as branchId,HEX(AES_ENCRYPT(assign_doctors.id,UNHEX(SHA2('".config('constant.mysql_custom_encrypt_key')."',512)))) as AssignId")
                                    ->join('patients', function($join) 
                                                {
                                                    $join->on('patients.id', '=', 'assign_doctors.patientId')
                                                         ->where('patients.is_active','=',1);
                                                })
                                    ->join('doctors', function($join) 
                                                {
                                                    $join->on('doctors.id', '=', 'assign_doctors.doctorId')
                                                         ->where('doctors.is_active','=',1);
                                                })
                                    ->where('assign_doctors.id','=',$original_id)
                                   ->first();
        return $patientDetails;
    }
    public static function updateAssignDoctor(Request $request)
    {
        $AssignId = "AES_DECRYPT(UNHEX('" . $request->AssignId . "'), UNHEX(SHA2('" . config('constant.mysql_custom_encrypt_key') . "',512)))";
        $where_sts = "id=" . $AssignId;
        $user = new User;
        $userId=$user->getDecryptedId($request->userId);
        $doctorId=$user->getDecryptedId($request->doctorId);
        
            return static::whereRaw($where_sts)->update(
                [
                    'doctorId' => $doctorId,
                    'updated_by' => $userId,
                ]
            );
    }
}
