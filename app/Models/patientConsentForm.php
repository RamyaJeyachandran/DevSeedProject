<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use config\constants;
class patientConsentForm extends Model
{
    public $timestamps = false;
    protected $table = 'patient_consent_forms';
    use HasFactory;
    protected $fillable = [
        'patientId',
        'consentFormId',
        'is_active',
        'created_by',
        'updated_by',
    ];
    public static function getSelectedConsentForm($patientId){
        $user = new User;
        $patient_id=$user->getDecryptedId($patientId);

        return DB::table('patient_consent_forms')->selectRaw("HEX(AES_ENCRYPT(consentFormId,UNHEX(SHA2('".config('constant.mysql_custom_encrypt_key')."',512)))) as consentFormId")
                                                 ->where([['is_active','=',1],['patientId','=',$patient_id]])
                                                 ->get();
    }
    public static function saveConsentForm($patientId,$consentId,$userId)
    {
        return static::create(
            [
                'patientId' => $patientId,
                'consentFormId' => $consentId,
                'created_by' => $userId
            ]
        ); 
    }
    public static function checkPatientConsentForm($patientId,$consentId,$userId){
        $formDetails=DB::table('patient_consent_forms')->select('id','is_active')->where([['patientId','=',$patientId],['consentFormId','=',$consentId]])
                                            ->first();
        if($formDetails!=NULL){
            if($formDetails->is_active==0){ //updated
                $result= static::where('id','=',$formDetails->id)
                                ->update(
                                [
                                    'updated_by' => $userId,
                                    'is_active'=> 1
                                ]);
            }
            return 1;//updated
        }
        return 0;//create new record
    }
    public static function deletePatientConsentForm($patientId,$userId){
        return static::where('patientId','=',$patientId)
        ->update(
        [
            'updated_by' => $userId,
            'is_active'=> 0
        ]);
    }
    public function getAllPatientConsentDetails($hospitalId,$branchId,$pagination)
    {
        $skip=$pagination['page'] ==1 ?0:(($pagination['page'] * $pagination['size'])-$pagination['size']);
        $where_sts="pcf.is_active=1 ".($hospitalId==0?"":" and p.hospitalId=".$hospitalId).($branchId==0?"":" and p.branchId=".$branchId)." ".(($pagination['filters_field'] =="" || $pagination['filters_value']=="")?"":" and p.".$pagination['filters_field']." ".$pagination['filters_type']." '".$pagination['filters_value']."%'");
        
        $consent_query="SELECT group_concat(c.formName) as consentForms,HEX(AES_ENCRYPT(pcf.patientId,UNHEX(SHA2('seedproject',512)))) as patientId,p.hcNo,p.name as patientName,p.phoneNo,p.email,p.profileImage,MIN(pcf.created_date) as created_date,MAX(pcf.updated_at) as updated_at FROM patient_consent_forms pcf JOIN patients p ON p.id=pcf.patientId AND p.is_active=1 JOIN consent_froms c ON c.id=pcf.consentFormId AND c.is_active=1 WHERE ".$where_sts."  GROUP BY pcf.patientId,p.hcNo,p.name,p.phoneNo,p.email,p.profileImage ORDER BY ".$pagination['sorters_field']." ".$pagination['sorters_dir']." LIMIT ".$pagination['size']." OFFSET ".$skip;

        $query_pageCount="SELECT group_concat(c.formName) as consentForms
        FROM patient_consent_forms pcf
        JOIN patients p ON p.id=pcf.patientId AND p.is_active=1
        JOIN consent_froms c ON c.id=pcf.consentFormId AND c.is_active=1
        WHERE ".$where_sts."
        GROUP BY pcf.patientId,p.hcNo,p.name,p.phoneNo,p.email";

        $patientConsentList['patientConsentList']= DB::select($consent_query);
 
        $lastPage_data= DB::select($query_pageCount);
        $lastPage=count($lastPage_data);

        $patientConsentList['last_page']=ceil($lastPage/$pagination['size']);
        return $patientConsentList;
    }
}
