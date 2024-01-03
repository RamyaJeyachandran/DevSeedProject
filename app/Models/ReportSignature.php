<?php

namespace App\Models;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\JoinClause;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ReportSignature extends Model
{
    public $timestamps = false;
    use HasFactory;
    protected $table = 'report_signatures';
    protected $fillable = [
        'leftDoctorId',
        'leftSignId',
        'rightDoctorId',
        'rightSignId',
        'centerDoctorId',
        'centerSignId',
        'isDefault',
        'hospitalId',
        'branchId',
        'is_active',
        'created_by',
        'updated_by',
    ];
    public function getAllSignature($hospitalId,$branchId,$pagination)
    {
        $skip=$pagination['page'] ==1 ?0:(($pagination['page'] * $pagination['size'])-$pagination['size']);
        $where_sts="report_signatures.is_active=1 ".($hospitalId==0?"":" and report_signatures.hospitalId=".$hospitalId).($branchId==0?"":"  and report_signatures.branchId=".$branchId)." ".(($pagination['filters_field'] =="" || $pagination['filters_value']=="")?"":" and ".$pagination['filters_field']." ".$pagination['filters_type']." '".$pagination['filters_value'].($pagination['filters_type']=="like"?"%'":"'"));

        $reportSignatureList["reportSignatureList"]=DB::table('report_signatures')->selectRaw("HEX(AES_ENCRYPT(report_signatures.id,UNHEX(SHA2('".config('constant.mysql_custom_encrypt_key')."',512)))) as id,leftDoctors.name as leftDoctorName,leftDoctors.doctorCodeNo as leftdoctorCodeNo,rightDoctors.name as rightDoctorName,rightDoctors.doctorCodeNo as rightdoctorCodeNo,centerDoctors.name as centerDoctorName,centerDoctors.doctorCodeNo as centerdoctorCodeNo,leftSign.signature as leftSign,rightSign.signature as rightSign,centerSign.signature as centerSign,isDefault,HEX(AES_ENCRYPT(leftDoctorId,UNHEX(SHA2('".config('constant.mysql_custom_encrypt_key')."',512)))) as leftDoctorId,HEX(AES_ENCRYPT(leftSignId,UNHEX(SHA2('".config('constant.mysql_custom_encrypt_key')."',512)))) as leftSignId,HEX(AES_ENCRYPT(rightDoctorId,UNHEX(SHA2('".config('constant.mysql_custom_encrypt_key')."',512)))) as rightDoctorId,HEX(AES_ENCRYPT(rightSignId,UNHEX(SHA2('".config('constant.mysql_custom_encrypt_key')."',512)))) as rightSignId,HEX(AES_ENCRYPT(centerDoctorId,UNHEX(SHA2('".config('constant.mysql_custom_encrypt_key')."',512)))) as centerDoctorId,HEX(AES_ENCRYPT(centerSignId,UNHEX(SHA2('".config('constant.mysql_custom_encrypt_key')."',512)))) as centerSignId,(CASE WHEN leftDoctors.departmentId = null THEN 0 ELSE leftDoctors.departmentId END) as leftdepartmentId,(CASE WHEN rightDoctors.departmentId = null THEN 0 ELSE rightDoctors.departmentId END) as rightdepartmentId,(CASE WHEN centerDoctors.departmentId = null THEN 0 ELSE centerDoctors.departmentId END) as centerdepartmentId")
                                    ->join('doctors as leftDoctors', function($join)
                                    {
                                         $join->on('leftDoctors.id', '=', 'report_signatures.leftDoctorId')
                                            ->where('leftDoctors.is_active','=',1);                                
                                    })
                                    ->join('doctors as rightDoctors', function($join)
                                    {
                                         $join->on('rightDoctors.id', '=', 'report_signatures.rightDoctorId')
                                            ->where('rightDoctors.is_active','=',1);                                
                                    })
                                    ->join('doctors as centerDoctors', function($join)
                                    {
                                         $join->on('centerDoctors.id', '=', 'report_signatures.centerDoctorId')
                                            ->where('centerDoctors.is_active','=',1);                                
                                    })
                                    ->join('doctorsignatures as leftSign', function($join)
                                    {
                                         $join->on('leftSign.id', '=', 'report_signatures.leftSignId')
                                            ->where('leftSign.is_active','=',1);                                
                                    })
                                    ->join('doctorsignatures as rightSign', function($join)
                                    {
                                         $join->on('rightSign.id', '=', 'report_signatures.rightSignId')
                                            ->where('rightSign.is_active','=',1);                                
                                    })
                                    ->join('doctorsignatures as centerSign', function($join)
                                    {
                                         $join->on('centerSign.id', '=', 'report_signatures.centerSignId')
                                            ->where('centerSign.is_active','=',1);                                
                                    })
                                    ->whereRaw($where_sts)
                                     ->skip($skip)->take($pagination['size']) //pagination
                                    ->orderBy($pagination['sorters_field'],$pagination['sorters_dir']) 
                                   ->get();

        $lastPage=$reportSignatureList["reportSignatureList"]->count();
        $reportSignatureList['last_page']=ceil($lastPage/$pagination['size']);
        return $reportSignatureList;
    }
    public function checkSignDuplicate($request)
    {
        $user_obj = new User;
        $doctorLeftId=$user_obj->getDecryptedId($request->doctorLeftId);
        $doctorRightId=$user_obj->getDecryptedId($request->doctorRightId);
        $doctorcenterId=$user_obj->getDecryptedId($request->doctorcenterId);
        $leftSignId=$user_obj->getDecryptedId($request->leftSignId);
        $rightSignId=$user_obj->getDecryptedId($request->rightSignId);
        $centerSignId=$user_obj->getDecryptedId($request->centerSignId);

        $duplicates = DB::table('report_signatures')
                            ->select('id')
                            ->where([['leftDoctorId','=',$doctorLeftId],['rightDoctorId','=',$doctorRightId],['centerDoctorId','=',$doctorcenterId],['rightSignId','=',$rightSignId],['leftSignId','=',$leftSignId],['centerSignId','=',$centerSignId]])
                            ->get();
        return $duplicates->count()>0?1:0;
    }
    public function checkSignDuplicateById($request)
    {
        $user_obj = new User;
        $reportSignId=$user_obj->getDecryptedId($request->reportSignId);
        $doctorLeftId=$user_obj->getDecryptedId($request->doctorLeftId);
        $doctorRightId=$user_obj->getDecryptedId($request->doctorRightId);
        $doctorcenterId=$user_obj->getDecryptedId($request->doctorcenterId);
        $leftSignId=$user_obj->getDecryptedId($request->leftSignId);
        $rightSignId=$user_obj->getDecryptedId($request->rightSignId);
        $centerSignId=$user_obj->getDecryptedId($request->centerSignId);

        $duplicates = DB::table('report_signatures')
                            ->select('id')
                            ->where([['leftDoctorId','=',$doctorLeftId],['rightDoctorId','=',$doctorRightId],['centerDoctorId','=',$doctorcenterId],['rightSignId','=',$rightSignId],['leftSignId','=',$leftSignId],['centerSignId','=',$centerSignId]])
                            ->get();

        $chk=0;
        if($duplicates->count()>1){
            foreach ($duplicates->data as $data){ 
                if($data->id!=$reportSignId)
                {
                    $chk=1;
                }
            }
        }
        return $chk;
    }
    public static function addReportSignature($request){
        $user_obj = new User;
        $userId=$user_obj->getDecryptedId($request->userId);
        $decrpt_hospitalId=(($request->hospitalId==NULL || $request->hospitalId==0) ?$request->hospitalId:$user_obj->getDecryptedId($request->hospitalId));
        $decrpt_branchId=($request->branchId==NULL?$request->branchId:$user_obj->getDecryptedId($request->branchId));

        $decrpt_hospitalId=($decrpt_hospitalId ==0 ? NULL :$decrpt_hospitalId);
        $decrpt_branchId=($decrpt_branchId==0 ? NULL : $decrpt_branchId);

        $doctorLeftId=$user_obj->getDecryptedId($request->doctorLeftId);
        $doctorRightId=$user_obj->getDecryptedId($request->doctorRightId);
        $doctorcenterId=$user_obj->getDecryptedId($request->doctorcenterId);
        $leftSignId=$user_obj->getDecryptedId($request->leftSignId);
        $rightSignId=$user_obj->getDecryptedId($request->rightSignId);
        $centerSignId=$user_obj->getDecryptedId($request->centerSignId);
        $isDefault=(isset($request->isDefault) && !empty($request->isDefault)) ?($request->isDefault=='on'?1:0) : 0;

        return static::create(
            [
                'leftDoctorId'=>$doctorLeftId,
                'leftSignId'=>$leftSignId,
                'rightDoctorId'=>$doctorRightId,
                'rightSignId'=>$rightSignId,
                'centerDoctorId'=>$doctorcenterId,
                'centerSignId'=>$centerSignId,
                'isDefault'=>$isDefault,
                'hospitalId'=>$decrpt_hospitalId,
                'branchId'=>$decrpt_branchId,
                'created_by'=>$userId
            ]
        );
    }
    public static function updateReportSignature($request){
        $user_obj = new User;
        $userId=$user_obj->getDecryptedId($request->userId);
        $reportSignId=$user_obj->getDecryptedId($request->reportSignId);
        $doctorLeftId=$user_obj->getDecryptedId($request->doctorLeftId);
        $doctorRightId=$user_obj->getDecryptedId($request->doctorRightId);
        $doctorcenterId=$user_obj->getDecryptedId($request->doctorcenterId);
        $leftSignId=$user_obj->getDecryptedId($request->leftSignId);
        $rightSignId=$user_obj->getDecryptedId($request->rightSignId);
        $centerSignId=$user_obj->getDecryptedId($request->centerSignId);
        $isDefault=(isset($request->isDefault) && !empty($request->isDefault)) ?($request->isDefault=='on'?1:0) : 0;

        if($isDefault==1)
        {
            $previous= static::where('isDefault','=',1)->update(
                [
                    'isDefault'=>0,
                    'updated_by'=>$userId
                ]
            );
        }

            return static::where('id','=',$reportSignId)->update(
                [
                    'leftDoctorId'=>$doctorLeftId,
                    'leftSignId'=>$leftSignId,
                    'rightDoctorId'=>$doctorRightId,
                    'rightSignId'=>$rightSignId,
                    'centerDoctorId'=>$doctorcenterId,
                    'centerSignId'=>$centerSignId,
                    'isDefault'=>$isDefault,
                    'updated_by'=>$userId
                ]
            );
    }
    public static function updateDefaultSignature($userId,$reportSignId,$isDefault){
        if($isDefault==1)
        {
            $previous= static::where('isDefault','=',1)->update(
                [
                    'isDefault'=>0,
                    'updated_by'=>$userId
                ]
            );
        }
        //New default sign
            return static::where('id','=',$reportSignId)->update(
                [
                    'isDefault'=>$isDefault,
                    'updated_by'=>$userId
                ]
            );
    }
    public static function getReportSignByHospitalId($hospitalId,$branchId){
        $where_sts="report_signatures.is_active=1 and report_signatures.isDefault=1 ".($hospitalId==0?"":" and report_signatures.hospitalId=".$hospitalId).($branchId==0?"":"  and report_signatures.branchId=".$branchId);

        return DB::table('report_signatures')->selectRaw("HEX(AES_ENCRYPT(report_signatures.id,UNHEX(SHA2('".config('constant.mysql_custom_encrypt_key')."',512)))) as id,leftSign.signature as leftSign,rightSign.signature as rightSign,centerSign.signature as centerSign,isDefault,leftDoctors.name as leftDoctorName,rightDoctors.name as rightDoctorName,centerDoctors.name as centerDoctorName")
        ->join('doctorsignatures as leftSign', function($join)
        {
             $join->on('leftSign.id', '=', 'report_signatures.leftSignId')
                ->where('leftSign.is_active','=',1);                                
        })
        ->join('doctorsignatures as rightSign', function($join)
        {
             $join->on('rightSign.id', '=', 'report_signatures.rightSignId')
                ->where('rightSign.is_active','=',1);                                
        })
        ->join('doctorsignatures as centerSign', function($join)
        {
             $join->on('centerSign.id', '=', 'report_signatures.centerSignId')
                ->where('centerSign.is_active','=',1);                                
        })
        ->join('doctors as leftDoctors', function($join)
        {
             $join->on('leftDoctors.id', '=', 'report_signatures.leftDoctorId')
                ->where('leftDoctors.is_active','=',1);                                
        })
        ->join('doctors as rightDoctors', function($join)
        {
             $join->on('rightDoctors.id', '=', 'report_signatures.rightDoctorId')
                ->where('rightDoctors.is_active','=',1);                                
        })
        ->join('doctors as centerDoctors', function($join)
        {
             $join->on('centerDoctors.id', '=', 'report_signatures.centerDoctorId')
                ->where('centerDoctors.is_active','=',1);                                
        })
        ->whereRaw($where_sts)
       ->first();
    }
}