<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use config\constants;

class pageSettings extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'page_settings';
    protected $fillable = [
        'userId',
        'marginRight',
        'marginLeft',
        'marginBottom',
        'marginTop',
        'is_active',
        'created_by',
        'updated_by'
    ];
    public static function addPageSettings($userId,$marginRight,$marginLeft,$marginBottom,$marginTop)
    {
        // $user_obj = new User;
        // $original_userId = $user_obj->getDecryptedId($userId);

        return static::create(
            [
             'userId'=>$userId,
             'marginRight' => $marginRight,
             'marginLeft'=>$marginLeft,
             'marginBottom'=>$marginBottom,
             'marginTop'=>$marginTop,
             'created_by'=>$userId
            ]
        );
    }
    public static function updatePageSettings(Request $request)
    {
        $user_obj = new User;
        $userId = $user_obj->getDecryptedId($request->userId);
        $pageSettingId= $user_obj->getDecryptedId($request->pageSettingId);

        return static::where('id',$pageSettingId)->update(
            [
                'marginRight' => $request->marginRight,
                'marginLeft'=>$request->marginLeft,
                'marginBottom'=>$request->marginBottom,
                'marginTop'=>$request->marginTop,
                'updated_by'=>$userId
            ]
        );
    }
    public function getPageSettingsByUserId($userId)
    {
        $page_settings=DB::table('page_settings')->selectRaw("HEX(AES_ENCRYPT(id,UNHEX(SHA2('".config('constant.mysql_custom_encrypt_key')."',512)))) as id,marginRight,marginLeft,marginBottom,marginTop")
                                    ->where([['userId','=',$userId],['is_active','=',1]])
                                   ->first();
        if($page_settings==null)
        {
            $query_sts = "SELECT HEX(AES_ENCRYPT(0,UNHEX(SHA2('".config('constant.mysql_custom_encrypt_key')."',512)))) as id,".config('constant.pageSetting.marginRight')." as marginRight,".config('constant.pageSetting.marginLeft')." as marginLeft,".config('constant.pageSetting.marginBottom')." as marginBottom,".config('constant.pageSetting.marginTop')." as marginTop";
            $result = DB::select($query_sts);
            $page_settings=$result[0];
        }
        return $page_settings;
    }
}
