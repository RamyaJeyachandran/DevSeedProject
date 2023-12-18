<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use config\constants;


class DoctorSignature extends Model
{
    public $timestamps = false;
    use HasFactory;
    protected $table = 'doctorsignatures';
    protected $fillable = [
        'signature',
        'doctorId',
        'hospitalId',
        'branchId',
        'is_active',
        'created_by',
        'updated_by',
    ];
    public static function addDoctorSignature($hospitalId,$branchId,$doctorId,$signature,$userId){
        return static::create(
            [
             'signature'=>$signature,
             'doctorId' => $doctorId,
             'hospitalId'=>$hospitalId,
             'branchId'=>$branchId,
             'created_by'=>$userId
            ]
        );
    }
    public function getDoctorSignatureByDoctorId($doctorId)
    {
        $user = new User;
        $original_doctorId=$user->getDecryptedId($doctorId);
        return DB::table('doctorsignatures')->selectRaw("HEX(AES_ENCRYPT(id,UNHEX(SHA2('".config('constant.mysql_custom_encrypt_key')."',512)))) as id,ROW_NUMBER() OVER(PARTITION BY doctorId) as sNo ,signature")
                                    ->where([['doctorId','=',$original_doctorId],['is_active','=',1]])
                                   ->get();
    }
    public function deleteSignature($id,$userId)
    {
        $user = new User;
        $original_id=$user->getDecryptedId($id);
        return static::where('id',$original_id)->update(
            [
             'is_active'=>0,
             'updated_by'=>$userId
            ]
        );
    }
}
