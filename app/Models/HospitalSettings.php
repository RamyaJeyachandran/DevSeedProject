<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use config\constants;

class HospitalSettings extends Model
{

    public $timestamps = false;
    use HasFactory;
    protected $table = 'hospitalSettings';
    protected $fillable = [
        'logo',
        'hospitalName',
        'address',
        'phoneNo',
        'email',
        'inChargePerson',
        'inChargePhoneNo',
        'is_subscribed',
        'is_active',
        'created_by',
        'updated_by'
    ];

    public static function addHospitalSettings(Request $request,$logo)
    {
        $user = new User;
        $userId=$user->getDecryptedId($request->userId);

        return static::create(
            [
                'hospitalName' => $request->hospitalName,
                'address' => $request->address,
                'phoneNo' => $request->phoneNo,
                'email' => $request->email,
                'inChargePerson' => $request->inChargePerson,
                'inChargePhoneNo' => $request->inChargePhoneNo,
                'created_by' => $userId,
                'logo'=>$logo
            ]
        );
    }
    public static function updateHospitalSettings(Request $request,$logo)
    {
        $hospitalId = "AES_DECRYPT(UNHEX('" . $request->hospitalId . "'), UNHEX(SHA2('" . config('constant.mysql_custom_encrypt_key') . "',512)))";
        $where_sts = "id=" . $hospitalId;
        $user = new User;
        $userId=$user->getDecryptedId($request->userId);
        if($logo==""){
            return static::whereRaw($where_sts)->update(
                [
                    'hospitalName' => $request->hospitalName,
                    'address' => $request->address,
                    'phoneNo' => $request->phoneNo,
                    'email' => $request->email,
                    'inChargePerson' => $request->inChargePerson,
                    'inChargePhoneNo' => $request->inChargePhoneNo,
                    'updated_by' => $userId,
                ]
            );
        }else{
            return static::whereRaw($where_sts)->update(
                [
                    'hospitalName' => $request->hospitalName,
                    'address' => $request->address,
                    'phoneNo' => $request->phoneNo,
                    'email' => $request->email,
                    'inChargePerson' => $request->inChargePerson,
                    'inChargePhoneNo' => $request->inChargePhoneNo,
                    'updated_by' => $userId,
                    'logo'=>$logo
                ]
            );
        }
    }
    public function getAllHospitalSettings($pagination)
    {
        $skip=$pagination['page'] ==1 ?0:(($pagination['page'] * $pagination['size'])-$pagination['size']);
        $where_sts="is_active=1  ".(($pagination['filters_field'] =="" || $pagination['filters_value']=="")?"":" and ".$pagination['filters_field']." ".$pagination['filters_type']." '".$pagination['filters_value']."%'");
       
        $hospitalSettingsList['hospitalSettingsList'] = DB::table('hospitalSettings')->selectRaw("logo,HEX(AES_ENCRYPT(id,UNHEX(SHA2('".config('constant.mysql_custom_encrypt_key')."',512)))) as id,hospitalName,address,phoneNo,email,inChargePerson,inChargePhoneNo,IF(is_subscribed=0,'No','Yes') as is_subscribed,IF(is_active=0,'In Active','Active') as status")
                                                            ->whereRaw($where_sts)
                                                            ->skip($skip)->take($pagination['size']) //pagination
                                                            ->orderBy($pagination['sorters_field'],$pagination['sorters_dir']) 
                                                             ->get();
        $lastPage=DB::table('hospitalSettings')->whereRaw($where_sts)->count();
        $hospitalSettingsList['last_page']=ceil($lastPage/$pagination['size']);
        return $hospitalSettingsList;
    }
    public function getHospitalSettingsById($id)
    {
        $where_sts = "id=" . $id;
        $hospitalDetails = DB::table('hospitalSettings')->selectRaw("logo,hospitalName,address,phoneNo,email,inChargePerson,inChargePhoneNo,IF(is_subscribed=0,'No','Yes') as is_subscribed,HEX(AES_ENCRYPT(id,UNHEX(SHA2('".config('constant.mysql_custom_encrypt_key')."',512)))) as hospitalId")
            ->whereRaw($where_sts)
            ->first();
        return $hospitalDetails;
    }

    public function getHospitalByEmailOrPhoneNo($request)
    {
        $email=$request->email;
        $phoneNo=$request->phoneNo;
        $hospitalDetailsList = DB::table('hospitalSettings')
            ->select("hospitalName")
            ->where(function ($q) use ($email, $phoneNo) {
                $q
                    ->Where("phoneNo", "=", $phoneNo)
                    ->orWhere("email", "=", $email);
            })->first();
        return $hospitalDetailsList;
    }
    public function deleteHospitalSettingsById($id, $userId)
    {
        $hospitalId = "AES_DECRYPT(UNHEX('" . $id . "'), UNHEX(SHA2('" . config('constant.mysql_custom_encrypt_key') . "',512)))";
        $where_sts = "id=" . $hospitalId;
        $user = new User;
        $updated_by=$user->getDecryptedId($userId);

        return static::whereRaw($where_sts)->update(
            [
                'is_active' => 0,
                'updated_by' => $updated_by
            ]
        );
    }
    public static function checkPhoneNoById($request){
        $email=$request->email;
        $phoneNo=$request->phoneNo;
        $hospitalId = "AES_DECRYPT(UNHEX('" . $request->hospitalId . "'), UNHEX(SHA2('" . config('constant.mysql_custom_encrypt_key') . "',512)))";
        $where_sts="is_active=1 and id <>".$hospitalId;
        $phoneNoList=DB::table('hospitalSettings')->select('hospitalName')->whereRaw($where_sts) ->where(function ($q) use ($email, $phoneNo) {
            $q
                ->Where("phoneNo", "=", $phoneNo)
                ->orWhere("email", "=", $email);
        })->first();
         return $phoneNoList; 
    }
    public static function hospitalActiveList(){
        $hospitalDetails = DB::table('hospitalSettings')->selectRaw("hospitalName as name,HEX(AES_ENCRYPT(id,UNHEX(SHA2('".config('constant.mysql_custom_encrypt_key')."',512)))) as id")
            ->where("is_active",1)
            ->get();
        return $hospitalDetails;
    }
}