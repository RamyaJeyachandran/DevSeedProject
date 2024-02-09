<?php

namespace App\Models;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PrePostWash extends Model
{
    public $timestamps = false;
    use HasFactory;
    protected $table = 'pre_post_washes';
    protected $fillable = [
        'liquefaction',
        'ph',
        'volume',
        'viscosity',
        'wbc',
        'preSpermConcentration',
        'preSpermCount',
        'preMotility',
        'preRapidProgressive',
        'preSlowProgressive',
        'preNonProgressive',
        'preImmotile',
        'media',
        'methodUsed',
        'countInMl',
        'postMotility',
        'postRapidProgressive',
        'postSlowProgressive',
        'postNonProgressive',
        'postImmotile',
        'impression',
        'patientId',
        'patientSeqNo',
        'doctorId',
        'reportSignId',
        'is_active',
        'created_by',
        'updated_by'
    ];
    public static function addPrePostWash($request)
    {
        $user = new User;
        $userId = $user->getDecryptedId($request->userId);
        $patientId = $user->getDecryptedId($request->patientId);
        $doctorId=$user->getDecryptedId($request->doctorId);

        $liquefaction = (isset($request->liquefaction) && !empty($request->liquefaction)) ? $request->liquefaction : NULL;
        $wbc = (isset($request->wbc) && !empty($request->wbc)) ? $request->wbc : NULL;
        $ph = (isset($request->ph) && !empty($request->ph)) ? $request->ph : NULL;
        $volume = (isset($request->volume) && !empty($request->volume)) ? $request->volume : NULL;
        $viscosity = (isset($request->viscosity) && !empty($request->viscosity)) ? $request->viscosity : NULL;
        $preSpermConcentration = (isset($request->preSpermConcentration) && !empty($request->preSpermConcentration)) ? $request->preSpermConcentration : NULL;
        $preSpermCount = (isset($request->preSpermCount) && !empty($request->preSpermCount)) ? $request->preSpermCount : NULL;
        $preMotility = (isset($request->preMotility) && !empty($request->preMotility)) ? $request->preMotility : NULL;
        $preRapidProgressive = (isset($request->preRapidProgressive) && !empty($request->preRapidProgressive)) ? $request->preRapidProgressive : NULL;
        $preSlowProgressive = (isset($request->preSlowProgressive) && !empty($request->preSlowProgressive)) ? $request->preSlowProgressive : NULL;
        $preNonProgressive = (isset($request->preNonProgressive) && !empty($request->preNonProgressive)) ? $request->preNonProgressive : NULL;
        $preImmotile = (isset($request->preImmotile) && !empty($request->preImmotile)) ? $request->preImmotile : NULL;
        $media = (isset($request->media) && !empty($request->media)) ? $request->media : NULL;
        $methodUsed = (isset($request->methodUsed) && !empty($request->methodUsed)) ? $request->methodUsed : NULL;
        $countInMl = (isset($request->countInMl) && !empty($request->countInMl)) ? $request->countInMl : NULL;
        $postMotility = (isset($request->postMotility) && !empty($request->postMotility)) ? $request->postMotility : NULL;
        $postRapidProgressive = (isset($request->postRapidProgressive) && !empty($request->postRapidProgressive)) ? $request->postRapidProgressive : NULL;
        $postSlowProgressive = (isset($request->postSlowProgressive) && !empty($request->postSlowProgressive)) ? $request->postSlowProgressive : NULL;
        $postNonProgressive = (isset($request->postNonProgressive) && !empty($request->postNonProgressive)) ? $request->postNonProgressive : NULL;
        $postImmotile = (isset($request->postImmotile) && !empty($request->postImmotile)) ? $request->postImmotile : NULL;
        $impression = (isset($request->impression) && !empty($request->impression)) ? $request->impression : NULL;
        $reportSignId= $user->getDecryptedId($request->reportSignId);
        $patientSeqNo=$request->seqNo;

        return static::create(
            [
                'liquefaction' => $liquefaction,
                'wbc' => $wbc,
                'ph' => $ph,
                'volume' => $volume,
                'viscosity' => $viscosity,
                'preSpermConcentration' => $preSpermConcentration,
                'preSpermCount' => $preSpermCount,
                'preMotility' => $preMotility,
                'preRapidProgressive' => $preRapidProgressive,
                'preSlowProgressive' => $preSlowProgressive,
                'preNonProgressive' => $preNonProgressive,
                'preImmotile' => $preImmotile,
                'media' => $media,
                'methodUsed' => $methodUsed,
                'countInMl' => $countInMl,
                'postMotility' => $postMotility,
                'postRapidProgressive' => $postRapidProgressive,
                'postSlowProgressive' => $postSlowProgressive,
                'postNonProgressive' => $postNonProgressive,
                'postImmotile' => $postImmotile,
                'impression'=>$impression,
                'patientSeqNo'=>$patientSeqNo,
                'patientId' => $patientId,
                'doctorId' => $doctorId,
                'reportSignId'=>$reportSignId,
                'created_by' => $userId
            ]
        );
    }
    public static function getAllPrePostWash($hospitalId,$branchId,$pagination)
    {
        $skip=$pagination['page'] ==1 ?0:(($pagination['page'] * $pagination['size'])-$pagination['size']);
        if($pagination['filters_field']=='hcNo' || $pagination['filters_field']=='patientName' || $pagination['filters_field']=='phoneNo')
        {
            $pagination['filters_field']=($pagination['filters_field']=='patientName'?'name':$pagination['filters_field']);
            $wherePatient_sts="patients.is_active=1 ".($hospitalId==0?"":" and patients.hospitalId=".$hospitalId).($branchId==0?"":" and patients.branchId=".$branchId)." and patients.".$pagination['filters_field']." ".$pagination['filters_type'].($pagination['filters_type']=='like'?" '%":"").$pagination['filters_value'].($pagination['filters_type']=='like'?"%'":"");
            $where_sts="pre_post_washes.is_active=1 ";
            $whereDoctor_sts="doctors.is_active=1";
        }
        else if($pagination["filters_field"]== "doctorName"){
            $where_sts="pre_post_washes.is_active=1 ";
            $whereDoctor_sts="doctors.is_active=1 and doctors.name ".$pagination['filters_type'].($pagination['filters_type']=='like'?" '%":"").$pagination['filters_value'].($pagination['filters_type']=='like'?"%'":"");
            $wherePatient_sts="patients.is_active=1 ".($hospitalId==0?"":" and patients.hospitalId=".$hospitalId).($branchId==0?"":" and patients.branchId=".$branchId);
        }
        else if($pagination["filters_field"]== "created_date"){
            $wherePatient_sts="patients.is_active=1 ".($hospitalId==0?"":" and patients.hospitalId=".$hospitalId).($branchId==0?"":" and patients.branchId=".$branchId);
            $whereDoctor_sts="doctors.is_active=1";
            $where_sts="pre_post_washes.is_active=1  and CAST(pre_post_washes.created_date AS DATE) ".$pagination['filters_type'].($pagination['filters_type']=='='?"'":"'%").Carbon::parse($pagination['filters_value'])->toDateString().($pagination['filters_type']=='='?"'":"%'");
        }
        else{
            $wherePatient_sts="patients.is_active=1 ".($hospitalId==0?"":" and patients.hospitalId=".$hospitalId).($branchId==0?"":" and patients.branchId=".$branchId);
            $whereDoctor_sts="doctors.is_active=1";
            $where_sts="pre_post_washes.is_active=1 ";
        }        
       
        $prePostWashList['prePostWashList']=DB::table('pre_post_washes')->selectRaw("ROW_NUMBER() OVER (PARTITION BY pre_post_washes.patientId ORDER BY pre_post_washes.created_date) as sNo,doctors.name as doctorName,patients.profileImage,patients.name as patientName,patients.hcNo,patients.email,patients.phoneNo,DATE_FORMAT(pre_post_washes.created_date, '%d-%m-%Y') as created_date,HEX(AES_ENCRYPT(pre_post_washes.id,UNHEX(SHA2('" . config('constant.mysql_custom_encrypt_key') . "',512)))) as id")
                                    ->join('doctors', function($join) use ($whereDoctor_sts)
                                        {
                                            $join->on('doctors.id', '=', 'pre_post_washes.doctorId')
                                            ->whereRaw($whereDoctor_sts);
                                        })
                                    ->join('patients', function($join) use ($wherePatient_sts)
                                        {
                                        $join->on('patients.id', '=', 'pre_post_washes.patientId')
                                            ->whereRaw($wherePatient_sts);
                                        })
                                    ->whereRaw($where_sts)
                                    ->skip($skip)->take($pagination['size']) //pagination
                                    ->orderBy($pagination['sorters_field'],$pagination['sorters_dir']) 
                                   ->get();
                                   
        $lastPage=$prePostWashList['prePostWashList']->count();

        $prePostWashList['last_page']=ceil($lastPage/$pagination['size']);

        return $prePostWashList;
    }
    public function deletePrePostWashById($id, $userId)
    {
        $user = new User;
        $prePostId = $user->getDecryptedId($id);
        $original_userId = $user->getDecryptedId($userId);

        return static::where('id',$prePostId)->update(
            [
                'is_active' => 0,
                'updated_by' => $original_userId
            ]
        );
    }
    public function  getPrePostWashById($id)
    {
        $where_sts = "pre_post_washes.id=" . $id;
        $prePostDetails = DB::table('pre_post_washes')->selectRaw("patientSeqNo,COALESCE(pre_post_washes.liquefaction,'') as liquefaction,COALESCE(pre_post_washes.ph,'') as ph,COALESCE(pre_post_washes.volume,'') as volume,COALESCE(pre_post_washes.viscosity,'') as viscosity,COALESCE(pre_post_washes.wbc,'') as wbc,COALESCE(pre_post_washes.preSpermConcentration,'') as preSpermConcentration,COALESCE(pre_post_washes.preSpermCount,'') as preSpermCount,COALESCE(pre_post_washes.preMotility,'') as preMotility,COALESCE(pre_post_washes.preRapidProgressive,'') as preRapidProgressive,COALESCE(pre_post_washes.preSlowProgressive,'') as preSlowProgressive,COALESCE(pre_post_washes.preNonProgressive,'') as preNonProgressive,COALESCE(pre_post_washes.preImmotile,'') as preImmotile,COALESCE(pre_post_washes.media,'') as media,COALESCE(pre_post_washes.methodUsed,'') as methodUsed,COALESCE(pre_post_washes.countInMl,'') as countInMl,COALESCE(pre_post_washes.postMotility,'') as postMotility,COALESCE(pre_post_washes.postRapidProgressive,'') as postRapidProgressive,COALESCE(pre_post_washes.postSlowProgressive,'') as postSlowProgressive,COALESCE(pre_post_washes.postNonProgressive,'') as postNonProgressive,COALESCE(pre_post_washes.postImmotile,'') as postImmotile,COALESCE(pre_post_washes.impression,'') as impression,HEX(AES_ENCRYPT(pre_post_washes.patientId,UNHEX(SHA2('" . config('constant.mysql_custom_encrypt_key') . "',512)))) as patientId,HEX(AES_ENCRYPT(pre_post_washes.doctorId,UNHEX(SHA2('" . config('constant.mysql_custom_encrypt_key') . "',512)))) as doctorId,HEX(AES_ENCRYPT(pre_post_washes.id,UNHEX(SHA2('" . config('constant.mysql_custom_encrypt_key') . "',512)))) as prePostId,HEX(AES_ENCRYPT(patients.hospitalId,UNHEX(SHA2('" . config('constant.mysql_custom_encrypt_key') . "',512)))) as hospitalId,HEX(AES_ENCRYPT(patients.branchId,UNHEX(SHA2('" . config('constant.mysql_custom_encrypt_key') . "',512)))) as branchId,patients.name,patients.hcNo,patients.phoneNo,patients.spouseName,COALESCE(leftSign.signature,'') as leftSignature,COALESCE(centerSign.signature,'') as centerSignature,COALESCE(rightSign.signature,'') as rightSignature,COALESCE(leftDoctor.name,'') as leftDoctor,COALESCE(centerDoctor.name,'') as centerDoctor,COALESCE(rightDoctor.name,'') as rightDoctor,COALESCE(HEX(AES_ENCRYPT(pre_post_washes.reportSignId,UNHEX(SHA2('" . config('constant.mysql_custom_encrypt_key') . "',512)))),0) as reportSignId")
            ->join("patients","patients.id","=","pre_post_washes.patientId")
            ->leftJoin('report_signatures','pre_post_washes.reportSignId','=','report_signatures.id')
            ->leftJoin('doctorsignatures as leftSign', 'report_signatures.leftSignId','=','leftSign.id')
            ->leftJoin('doctorsignatures as centerSign', 'report_signatures.centerSignId','=','centerSign.id')
            ->leftJoin('doctorsignatures as rightSign', 'report_signatures.rightSignId','=','rightSign.id')
            ->leftJoin('doctors as leftDoctor', 'report_signatures.leftDoctorId','=','leftDoctor.id')
            ->leftJoin('doctors as centerDoctor', 'report_signatures.centerDoctorId','=','centerDoctor.id')
            ->leftJoin('doctors as rightDoctor', 'report_signatures.rightDoctorId','=','rightDoctor.id')
            ->whereRaw($where_sts)
            ->first();
        return $prePostDetails;
    }
    public static function updatePrePostAnalysis($request)
    {
        $user = new User;
        $userId = $user->getDecryptedId($request->userId);
        $doctorId=$user->getDecryptedId($request->doctorId);
        $prePostId=$user->getDecryptedId($request->prePostId);

        $liquefaction = (isset($request->liquefaction) && !empty($request->liquefaction)) ? $request->liquefaction : NULL;
        $wbc = (isset($request->wbc) && !empty($request->wbc)) ? $request->wbc : NULL;
        $ph = (isset($request->ph) && !empty($request->ph)) ? $request->ph : NULL;
        $volume = (isset($request->volume) && !empty($request->volume)) ? $request->volume : NULL;
        $viscosity = (isset($request->viscosity) && !empty($request->viscosity)) ? $request->viscosity : NULL;
        $preSpermConcentration = (isset($request->preSpermConcentration) && !empty($request->preSpermConcentration)) ? $request->preSpermConcentration : NULL;
        $preSpermCount = (isset($request->preSpermCount) && !empty($request->preSpermCount)) ? $request->preSpermCount : NULL;
        $preMotility = (isset($request->preMotility) && !empty($request->preMotility)) ? $request->preMotility : NULL;
        $preRapidProgressive = (isset($request->preRapidProgressive) && !empty($request->preRapidProgressive)) ? $request->preRapidProgressive : NULL;
        $preSlowProgressive = (isset($request->preSlowProgressive) && !empty($request->preSlowProgressive)) ? $request->preSlowProgressive : NULL;
        $preNonProgressive = (isset($request->preNonProgressive) && !empty($request->preNonProgressive)) ? $request->preNonProgressive : NULL;
        $preImmotile = (isset($request->preImmotile) && !empty($request->preImmotile)) ? $request->preImmotile : NULL;
        $media = (isset($request->media) && !empty($request->media)) ? $request->media : NULL;
        $methodUsed = (isset($request->methodUsed) && !empty($request->methodUsed)) ? $request->methodUsed : NULL;
        $countInMl = (isset($request->countInMl) && !empty($request->countInMl)) ? $request->countInMl : NULL;
        $postMotility = (isset($request->postMotility) && !empty($request->postMotility)) ? $request->postMotility : NULL;
        $postRapidProgressive = (isset($request->postRapidProgressive) && !empty($request->postRapidProgressive)) ? $request->postRapidProgressive : NULL;
        $postSlowProgressive = (isset($request->postSlowProgressive) && !empty($request->postSlowProgressive)) ? $request->postSlowProgressive : NULL;
        $postNonProgressive = (isset($request->postNonProgressive) && !empty($request->postNonProgressive)) ? $request->postNonProgressive : NULL;
        $postImmotile = (isset($request->postImmotile) && !empty($request->postImmotile)) ? $request->postImmotile : NULL;
        $impression = (isset($request->impression) && !empty($request->impression)) ? $request->impression : NULL;

        return static::where('id','=',$prePostId)->update(
            [
                'liquefaction' => $liquefaction,
                'wbc' => $wbc,
                'ph' => $ph,
                'volume' => $volume,
                'viscosity' => $viscosity,
                'preSpermConcentration' => $preSpermConcentration,
                'preSpermCount' => $preSpermCount,
                'preMotility' => $preMotility,
                'preRapidProgressive' => $preRapidProgressive,
                'preSlowProgressive' => $preSlowProgressive,
                'preNonProgressive' => $preNonProgressive,
                'preImmotile' => $preImmotile,
                'media' => $media,
                'methodUsed' => $methodUsed,
                'countInMl' => $countInMl,
                'postMotility' => $postMotility,
                'postRapidProgressive' => $postRapidProgressive,
                'postSlowProgressive' => $postSlowProgressive,
                'postNonProgressive' => $postNonProgressive,
                'postImmotile' => $postImmotile,
                'impression'=>$impression,
                'doctorId' => $doctorId,
                'updated_by' => $userId
            ]
        );
    }
    public function  getPrePostWashByIdForPrint($id)
    {   
        $prePostWashDetails = DB::table('pre_post_washes')->selectRaw("COALESCE(pre_post_washes.liquefaction,'') as liquefaction,COALESCE(pre_post_washes.ph,'') as ph,COALESCE(pre_post_washes.volume,'') as volume,COALESCE(pre_post_washes.viscosity,'') as viscosity,COALESCE(pre_post_washes.wbc,'') as wbc,COALESCE(pre_post_washes.preSpermConcentration,'') as preSpermConcentration,COALESCE(pre_post_washes.preSpermCount,'') as preSpermCount,COALESCE(pre_post_washes.preMotility,'') as preMotility,COALESCE(pre_post_washes.preRapidProgressive,'') as preRapidProgressive,COALESCE(pre_post_washes.preSlowProgressive,'') as preSlowProgressive,COALESCE(pre_post_washes.preNonProgressive,'') as preNonProgressive,COALESCE(pre_post_washes.preImmotile,'') as preImmotile,COALESCE(pre_post_washes.media,'') as media,COALESCE(pre_post_washes.methodUsed,'') as methodUsed,COALESCE(pre_post_washes.countInMl,'') as countInMl,COALESCE(pre_post_washes.postMotility,'') as postMotility,COALESCE(pre_post_washes.postRapidProgressive,'') as postRapidProgressive,COALESCE(pre_post_washes.postSlowProgressive,'') as postSlowProgressive,COALESCE(pre_post_washes.postNonProgressive,'') as postNonProgressive,COALESCE(pre_post_washes.postImmotile,'') as postImmotile,COALESCE(pre_post_washes.impression,'') as impression,
        patients.name, 
        patients.hcNo,
        DATE_FORMAT(patients.dob, '%d-%m-%Y') as dob,
        patients.age,
        patients.gender,
        patients.spouseName,
        doctors.name as doctorName,
        DATE_FORMAT(patients.created_date, '%d-%m-%Y') as created_date
        ,COALESCE(leftSign.signature,'') as leftSignature,COALESCE(centerSign.signature,'') as centerSignature,COALESCE(rightSign.signature,'') as rightSignature
        ,COALESCE(leftDoctor.name,'') as leftDoctor,COALESCE(centerDoctor.name,'') as centerDoctor,COALESCE(rightDoctor.name,'') as rightDoctor")
            ->where('pre_post_washes.id','=',$id)
            ->join("patients","patients.id","=","pre_post_washes.patientId")
            ->join("doctors","doctors.id","=","pre_post_washes.doctorId")
            ->leftJoin('report_signatures','pre_post_washes.reportSignId','=','report_signatures.id')
            ->leftJoin('doctorsignatures as leftSign', 'report_signatures.leftSignId','=','leftSign.id')
            ->leftJoin('doctorsignatures as centerSign', 'report_signatures.centerSignId','=','centerSign.id')
            ->leftJoin('doctorsignatures as rightSign', 'report_signatures.rightSignId','=','rightSign.id')
            ->leftJoin('doctors as leftDoctor', 'report_signatures.leftDoctorId','=','leftDoctor.id')
            ->leftJoin('doctors as centerDoctor', 'report_signatures.centerDoctorId','=','centerDoctor.id')
            ->leftJoin('doctors as rightDoctor', 'report_signatures.rightDoctorId','=','rightDoctor.id')
            ->first();
        return $prePostWashDetails;
    }
    public function getPatientSequenceCount($patientId){
        return  DB::table('pre_post_washes')->select('id')->where([['is_active','=','1'],['patientId','=',$patientId]])->count();
    }
    public function getPrePostPatientDoctor($hospitalId,$branchId)
    {
        $user = new User;
        $decrypt_hospitalId=$user->getDecryptedId($hospitalId);
        $decrypt_branchId=$user->getDecryptedId($branchId);
        $decrypt_branchId=$decrypt_branchId==0?NULL:$decrypt_branchId;

        $where_sts="patients.is_active=1 and patients.hospitalId=".$decrypt_hospitalId.($decrypt_branchId==0|| $decrypt_branchId==null?"":" and patients.branchId=".$decrypt_branchId);

        $patientDetails=DB::table('patients')->selectRaw("HEX(AES_ENCRYPT(patients.id,UNHEX(SHA2('".config('constant.mysql_custom_encrypt_key')."',512)))) as id,CONCAT(patients.name,' - ',patients.hcNo) as name")
                                    ->join('hospitalsettings','hospitalsettings.id','=','patients.hospitalId')
                                    ->leftJoin('hospitalbranch','hospitalbranch.id','=','patients.branchId')
                                    ->whereRaw($where_sts)
                                    ->whereIn('patients.id',DB::table('semenanalysis')->where('is_active',1)->pluck('patientId'))
                                   ->get();

        return $patientDetails;
    }
}
