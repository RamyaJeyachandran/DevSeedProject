<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use config\constants;
class ConsentFrom extends Model
{
    public $timestamps = false;
    protected $table = 'consent_froms';
    use HasFactory;
    protected $fillable = [
        'formName',
        'formContent',
        'hospitalId',
        'branchId',
        'is_active',
        'created_by',
        'updated_by',
    ];

    public function getConsentFormList($hospitalId,$branchId){
        $user = new User;
        $orignal_hospitalId=$user->getDecryptedId($hospitalId);
        $orignal_branchId=$user->getDecryptedId($branchId);
        
        $new_branchId=(isset($orignal_branchId) && !empty($orignal_branchId)) ?$orignal_branchId : NULL;
        $where_sts="is_active=1 and hospitalId=".$orignal_hospitalId.((isset($orignal_branchId) && !empty($orignal_branchId)) ?" and branchId=".$new_branchId:"");
        
        return DB::table('consent_froms')->selectRaw("HEX(AES_ENCRYPT(id,UNHEX(SHA2('".config('constant.mysql_custom_encrypt_key')."',512)))) as id,formName,formContent")
                                        //  ->whereRaw($where_sts)
                                         ->get();
    }    
}
