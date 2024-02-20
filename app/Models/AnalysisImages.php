<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AnalysisImages extends Model
{
    public $timestamps = false;
    use HasFactory;
    protected $table = 'analysisimages';
    protected $fillable = [
        'semenAnalysisId',
        'imageFile',
        'is_active',
        'created_by',
        'updated_by'
    ];

    public static function addAnalysisImages($userId,$semenAnalysisId,$imageFile)
    {
        $user = new User;
        $user_id = $user->getDecryptedId($userId);
        return static::create(
            [
                'semenAnalysisId' => $semenAnalysisId,
                'imageFile' => $imageFile,
                'created_by' => $user_id
            ]
        );
    }
    public static function getAnalysisImage($id)
    {
        $chatDetails=DB::table('analysisimages')->selectRaw("HEX(AES_ENCRYPT(id,UNHEX(SHA2('".config('constant.mysql_custom_encrypt_key')."',512)))) as id,imageFile")
                                    ->where([['is_active','=',1],['semenAnalysisId','=',$id]])
                                    ->get();

        return $chatDetails;
    }
    public static function deleteAnalysisImage($userId,$id)
    {
        $user = new User;
        $user_id = $user->getDecryptedId($userId);
        $original_id = $user->getDecryptedId($id);
        return static::where('id','=',$original_id)->update(
            [
                'is_active'=>0,
                'updated_by'=>$user_id
            ]
        );

    }
}
