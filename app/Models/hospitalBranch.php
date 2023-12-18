<?php

namespace App\Models;

use config\constants;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Session;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class HospitalBranch extends Model
{
    public $timestamps = false;
    use HasFactory;
    protected $table = 'hospitalbranch';
    protected $fillable = [

        'branchName',
        'logo',
        'address',
        'phoneNo',
        'email',
        'contactPerson',
        'contactPersonPhNo',
        'hospitalId',
        'isSubscribed',
        'is_active',
        'created_by',
        'updated_by'
    ];

    public static function addHospitalBranch(Request $request,$logo)
    {
        $user = new User;
        $userId=$user->getDecryptedId($request->userId);
        $hospitalId=$user->getDecryptedId($request->hospitalId);
        return static::create(
            [
                'branchName' => $request->branchName,
                'address' => $request->address,
                'phoneNo' => $request->phoneNo,
                'email' => $request->email,
                'contactPerson' => $request->contactPerson,
                'contactPersonPhNo' => $request->contactPersonPhNo,
                'hospitalId' => $hospitalId,
                'created_by' => $userId,
                'logo'=>$logo
            ]
        );
    }
    public static function updateHospitalBranch(Request $request,$logo)
    {
        $branchId = "AES_DECRYPT(UNHEX('" . $request->branchId . "'), UNHEX(SHA2('" . config('constant.mysql_custom_encrypt_key') . "',512)))";
        $where_sts = "id=" . $branchId;
        $user = new User;
        $userId=$user->getDecryptedId($request->userId);
        if($logo==""){
            return static::whereRaw($where_sts)->update(
                [
                    'branchName' => $request->branchName,
                    'address' => $request->address,
                    'phoneNo' => $request->phoneNo,
                    'email' => $request->email,
                    'contactPerson' => $request->contactPerson,
                    'contactPersonPhNo' => $request->contactPersonPhNo,
                    'updated_by' => $userId,
                ]
            );
        }else{
            return static::whereRaw($where_sts)->update(
                [
                    'branchName' => $request->branchName,
                    'address' => $request->address,
                    'phoneNo' => $request->phoneNo,
                    'email' => $request->email,
                    'contactPerson' => $request->contactPerson,
                    'contactPersonPhNo' => $request->contactPersonPhNo,
                    'updated_by' => $userId,
                    'logo'=>$logo
                ]
            );
        }
    }
    public function getAllHospitalBranch($hospitalId,$pagination)
    {
        $skip=$pagination['page'] ==1 ?0:(($pagination['page'] * $pagination['size'])-$pagination['size']);
        $where_sts="hospitalbranch.is_active=1 ".(($hospitalId==NULL || $hospitalId==0?"":" and hospitalbranch.hospitalId=".$hospitalId))." ".(($pagination['filters_field'] =="" || $pagination['filters_value']=="")?"":" and  hospitalbranch.".$pagination['filters_field']." ".$pagination['filters_type']." '".$pagination['filters_value']."%'");
       
        $branchList['branchList'] = DB::table('hospitalbranch')
            ->selectRaw("hospitalbranch.logo,HEX(AES_ENCRYPT(hospitalbranch.id,UNHEX(SHA2('".config('constant.mysql_custom_encrypt_key')."',512)))) as id,hospitalsettings.hospitalName,hospitalbranch.branchName,hospitalbranch.address,hospitalbranch.phoneNo,hospitalbranch.email,hospitalbranch.contactPerson,hospitalbranch.contactPersonPhNo,IF(hospitalbranch.is_active=0,'In Active','Active') as status,IF(hospitalbranch.isSubscribed=0,'No','Yes') as is_subscribed")
            ->join('hospitalsettings', 'hospitalsettings.id', '=', 'hospitalbranch.hospitalId')
            ->whereRaw($where_sts)
            ->skip($skip)->take($pagination['size']) //pagination
            ->orderBy($pagination['sorters_field'],$pagination['sorters_dir']) 
            ->get();

        $branchList['lastPage']=DB::table('hospitalbranch')->join('hospitalsettings', 'hospitalsettings.id', '=', 'hospitalbranch.hospitalId')
                                                           ->whereRaw($where_sts)->count();
        return $branchList;
    }
    public function getHospitalBranchById($id)
    {
        $where_sts = "hospitalbranch.id=" . $id;
        $branchDetails = DB::table('hospitalbranch')->selectRaw("
        hospitalbranch.logo,hospitalsettings.hospitalName,hospitalbranch.branchName,hospitalbranch.address,hospitalbranch.phoneNo,hospitalbranch.email,hospitalbranch.contactPerson,hospitalbranch.contactPersonPhNo,HEX(AES_ENCRYPT(hospitalbranch.hospitalId,UNHEX(SHA2('".config('constant.mysql_custom_encrypt_key')."',512)))) as hospitalId,HEX(AES_ENCRYPT(hospitalbranch.id,UNHEX(SHA2('".config('constant.mysql_custom_encrypt_key')."',512)))) as branchId")
        ->join('hospitalsettings', 'hospitalsettings.id', '=', 'hospitalbranch.hospitalId')
            ->whereRaw($where_sts)
            ->first();
        return $branchDetails;
    }

    public function getBranchByEmailorPhnNo($request)
    {
        $email=$request->email;
        $phoneNo=$request->phoneNo;
        $branchList = DB::table('hospitalbranch')
            ->select("branchName")
            ->where(function ($q) use ($email, $phoneNo) {
                $q
                    ->Where("phoneNo", "=", $phoneNo)
                    ->orWhere("email", "=", $email);
            })->first();
        return $branchList;
    }
    public static function deleteHospitalBranchById($id, $userId)
    {
        $branchId = "AES_DECRYPT(UNHEX('" . $id . "'), UNHEX(SHA2('" . config('constant.mysql_custom_encrypt_key') . "',512)))";
        $where_sts = "id=" . $branchId;
        $user = new User;
        $orignal_userId=$user->getDecryptedId($userId);

        return static::whereRaw($where_sts)->update(
            [
                'is_active' => 0,
                'updated_by' => $orignal_userId
            ]
        );
    }
    public static function getHospitalList(){
        return DB::table('hospitalsettings')->selectRaw("HEX(AES_ENCRYPT(id,UNHEX(SHA2('".config('constant.mysql_custom_encrypt_key')."',512)))) as id,hospitalName")->where('is_active','=',1)->get();
    }
    public static function getBranchListByHospitalId($hospitalId){
        $user = new User;
        $orignal_hospitalId=$user->getDecryptedId($hospitalId);
        
        return DB::table('hospitalbranch')->selectRaw("HEX(AES_ENCRYPT(id,UNHEX(SHA2('".config('constant.mysql_custom_encrypt_key')."',512)))) as id,branchName")
                                          ->where([['is_active','=',1],['hospitalId','=',$orignal_hospitalId]])
                                          ->get();
    }
    public static function checkPhoneNoById($request){
        $email=$request->email;
        $phoneNo=$request->phoneNo;
        $branchId = "AES_DECRYPT(UNHEX('" . $request->branchId . "'), UNHEX(SHA2('" . config('constant.mysql_custom_encrypt_key') . "',512)))";
        $where_sts="is_active=1 and id <>".$branchId;
        $phoneNoList=DB::table('hospitalbranch')->select('branchName')->whereRaw($where_sts) ->where(function ($q) use ($email, $phoneNo) {
            $q
                ->Where("phoneNo", "=", $phoneNo)
                ->orWhere("email", "=", $email);
        })->first();
         return $phoneNoList; 
    }
    public static function getSubscribed($userId){
        $session_branchId = Session::get('branchId');
        $branchId = "AES_DECRYPT(UNHEX('" . $session_branchId . "'), UNHEX(SHA2('" . config('constant.mysql_custom_encrypt_key') . "',512)))";
        $where_sts = "id=" . $branchId;

                return static::whereRaw($where_sts)->update(
                    [
                        'is_subscribed'=>1,
                        'updated_by' => $userId,
                    ]
                );
    }
}