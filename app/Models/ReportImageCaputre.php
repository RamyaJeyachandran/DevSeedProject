<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ReportImageCaputre extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'image_capture_settings';
    protected $fillable = [
        'userId',
        'isCaptureImage',
        'is_active',
        'created_by',
        'updated_by',
    ];
    public function getImageSettingsByUserId($userId)
    {
        $image_settings=DB::table('image_capture_settings')->selectRaw("id,isCaptureImage")
                                    ->where([['userId','=',$userId],['is_active','=',1]])
                                   ->first();
        if($image_settings==null)
        {
            $query_sts = "SELECT 0 as id,0 as isCaptureImage";
            $result = DB::select($query_sts);
            $image_settings=$result[0];
        }
        return $image_settings;
    }
    public static function addImageSettings($user_id,$isSet)
    {
        return static::create(
            [
             'userId'=>$user_id,
             'isCaptureImage' => $isSet,
             'created_by'=>$user_id
            ]
        );
    }
    public static function updateImageSettings($user_id,$isSet)
    {
        return static::where('userId',$user_id)->update(
            [
                'isCaptureImage' => $isSet,
                'updated_by'=>$user_id
            ]
        );
    }
}
