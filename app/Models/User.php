<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use config\constants;
use Carbon\Carbon;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    public $timestamps = false;
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'user_type_id',
        'is_login',
        'is_active',
        'user_id',
        'created_by',
        'colorId',
        'defaultHospitalId',
        'defaultBranchId',
        'lastActivityDateTime',
        'sessionId'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        // 'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];
    public function createLogin($request, $userTypeTd, $id, $name)
    {
        $userId = $this->getDecryptedId($request->userId);

        $hashed = Hash::make($request->password, [
            'rounds' => 12,
        ]);
        return static::create(
            [
                'name' => $name,
                'email' => $request->email,
                'password' => $hashed,
                'user_type_id' => $userTypeTd,
                'created_by' => $userId,
                'user_id' => $id
            ]
        );
    }
    public function updateLogin($user_id,$login_userId,$name,$email,$typeId)
    {
        $user_id = $this->getDecryptedId($user_id);
        $id=$this->getDecryptedId($login_userId);
        return static::where([['user_id','=', $user_id],['user_type_id','=', $typeId]])->update(
            [
                'name' => $name,
                'email' => $email,
                'updated_by' => $id,
            ]
        );
    }
    public function checkEmailIdForEdit($email,$userId)
    {
        $user_id = $this->getDecryptedId($userId);
        return DB::table('users')->where([['email', '=', $email],['user_id','!=',$user_id]])->get();
    }
    public function checkEmailId($email)
    {
        return DB::table('users')->where('email', '=', $email)->where('is_active', '=', 1)->get();
    }
    public function getDecryptedId($encryptedId)
    {
        $select_sts = "SELECT AES_DECRYPT(UNHEX('" . $encryptedId . "'), UNHEX(SHA2('" . config('constant.mysql_custom_encrypt_key') . "',512))) as id";
        $result = DB::select($select_sts);
        return $result[0]->id;
    }
    public function getEncryptedId($decryptdId)
    {
        $select_sts = "SELECT HEX(AES_ENCRYPT(" . $decryptdId . ",UNHEX(SHA2('" . config('constant.mysql_custom_encrypt_key') . "',512)))) as id";
        $result = DB::select($select_sts);
        return $result[0]->id;
    }
    public function deleteLogin($userId, $userTypeTd, $loginUserId)
    {
        $original_loginUserId = $this->getDecryptedId($loginUserId);
        $original_UserId = $this->getDecryptedId($userId);

        return static::where([['user_id', '=', $original_UserId], ['user_type_id', '=', $userTypeTd]])->update(
            [
                'is_active' => 0,
                'updated_by' => $original_loginUserId
            ]
        );
    }
    public function getUserInfo($id)
    {
        $userId = $this->getDecryptedId($id);
        return DB::table('users')->selectRaw("HEX(AES_ENCRYPT(id,UNHEX(SHA2('".config('constant.mysql_custom_encrypt_key')."',512)))) as id,name,email,HEX(AES_ENCRYPT(user_id,UNHEX(SHA2('".config('constant.mysql_custom_encrypt_key')."',512)))) as user_id,user_type_id,COALESCE(colorId,'".config('constant.colorId')."') as colorId,HEX(AES_ENCRYPT(COALESCE(defaultHospitalId,0),UNHEX(SHA2('".config('constant.mysql_custom_encrypt_key')."',512)))) as defaultHospitalId,HEX(AES_ENCRYPT(COALESCE(defaultBranchId,0),UNHEX(SHA2('".config('constant.mysql_custom_encrypt_key')."',512)))) as defaultBranchId")->where("id",$userId)->first();
    }
    public function updatePassword($request){
        $original_userId = $this->getDecryptedId($request->userId);
        $hashed_password = Hash::make($request->newPassword, [
            'rounds' => 12,
        ]);
        return static::where('id',$original_userId)->update(
            [
                'password' => $hashed_password,
                'updated_by' => $original_userId
            ]
        );     
    }
    public function userProfile($id)
    {
        $original_id = $this->getDecryptedId($id);
        
        $profileDetails=array();
        $userInfo=DB::table('users')->where('id',$original_id)->first(); 
        if(empty($userInfo)){
            return null;
        }else
        {
            switch ($userInfo->user_type_id) {
                case 2:
                    $profileDetails= DB::table('hospitalsettings')->selectRaw("logo as Image,hospitalName as Name,address,phoneNo,email,inChargePerson,inChargePhoneNo,IF(is_subscribed=0,'No','Yes') as is_subscribed,HEX(AES_ENCRYPT(id,UNHEX(SHA2('".config('constant.mysql_custom_encrypt_key')."',512)))) as id")
                                                        ->where('id',$userInfo->user_id)
                                                        ->first();
                    break;
                case 4:
                    $profileDetails=DB::table('hospitalbranch')->selectRaw("hospitalbranch.logo  as Image,hospitalsettings.hospitalName,hospitalbranch.branchName as Name,hospitalbranch.address,hospitalbranch.phoneNo,hospitalbranch.email,hospitalbranch.contactPerson as inChargePerson,hospitalbranch.contactPersonPhNo as inChargePhoneNo,HEX(AES_ENCRYPT(hospitalbranch.hospitalId,UNHEX(SHA2('".config('constant.mysql_custom_encrypt_key')."',512)))) as hospitalId,HEX(AES_ENCRYPT(hospitalbranch.id,UNHEX(SHA2('".config('constant.mysql_custom_encrypt_key')."',512)))) as id")
                                                ->join('hospitalsettings', 'hospitalsettings.id', '=', 'hospitalbranch.hospitalId')
                                                ->where([['hospitalbranch.is_active','=',1],['hospitalbranch.id','=',$userInfo->user_id]])
                                                ->first();
                    break;
                case 5:
                    $profileDetails=DB::table('doctors')->selectRaw("COALESCE(doctors.bloodGroup,'Not Provided') as bloodGroup,COALESCE(doctors.dob,'Not Provided') as dob,COALESCE(doctors.gender,'Not Provided') as gender,COALESCE(doctors.education,'Not Provided') as education,COALESCE(doctors.designation,'Not Provided') as designation,COALESCE(doctors.experience,'Not Provided') as experience,COALESCE(doctors.address,'Not Provided') as address,COALESCE(doctors.is_active,'') as status,doctors.name as Name,doctors.doctorCodeNo,doctors.phoneNo,doctors.email,doctors.profileImage as Image,HEX(AES_ENCRYPT(doctors.id,UNHEX(SHA2('".config('constant.mysql_custom_encrypt_key')."',512)))) as id,COALESCE(departments.name,'Not Provided') as department")
                                                        ->leftJoin('departments', 'departments.id', '=', 'doctors.departmentId')
                                                        ->where([['doctors.id','=',$userInfo->user_id],['doctors.is_active','=',1]])
                                                    ->first();
                    break;
            }
        }
        return $profileDetails;
    }
    public function userInformation($user_id){
        $original_id = $this->getDecryptedId($user_id);
        return DB::table('users')->where('id',$original_id)->first(); 
    }
    public function forgetPassword($request,$user_id){
        $hashed_password = Hash::make($request->newPassword, [
            'rounds' => 12,
        ]);
        return static::where('id',$user_id)->update(
            [
                'password' => $hashed_password,
                'updated_by' => $user_id
            ]
        );     
    }
    public function setColorId($request){
        $user_id= $this->getDecryptedId($request->userId);

        return static::where('id',$user_id)->update(
            [
                'colorId' => $request->colorId,
                'updated_by' => $user_id
            ]
        );     
    }
    public function hexToRgbMethod1($hex) {
        $r = hexdec(substr($hex, 1, 2));
        $g = hexdec(substr($hex, 3, 2));
        $b = hexdec(substr($hex, 5, 2));
        return array($r, $g, $b);
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
    public function updateDefaultHospital($request){
        $user_id= $this->getDecryptedId($request->userId);
        $hosptialId= $this->getDecryptedId($request->hospitalId);
        $branchId= (isset($request->branchId) && !empty($request->branchId)) ?$this->getDecryptedId($request->branchId) : NULL;

        return static::where('id',$user_id)->update(
            [
                'defaultHospitalId' => $hosptialId,
                'defaultBranchId' => $branchId,
                'updated_by' => $user_id
            ]
        );     
    }
    public function updateSessionDetails($user_id,$sessionId){

        return static::where('id',$user_id)->update(
            [
                'sessionId'=>$sessionId,
                'lastActivityDateTime' => Carbon::now(),
                'is_login'=>1,
                'updated_by' => $user_id
            ]
        );     
    }
    public function updateIsLogin($user_id){

        return static::where('id',$user_id)->update(
            [
                'is_login'=>0,
                'sessionId'=>'',
                'lastActivityDateTime' => Carbon::now(),
                'updated_by' => $user_id
            ]
        );     
    }
    public static function getLastActivityDateTime($user_id){
        return DB::table('users')->selectRaw("lastActivityDateTime,DATE(lastActivityDateTime) as lastActivityDate,TIME(lastActivityDateTime) as lastActivityTime,sessionId")
                                          ->where([['is_active','=',1],['id','=',$user_id]])
                                          ->first();
    }
    public static function setMenuSession($request,$user_type_id)
    {
        $isAdmin=$user_type_id == 1;
        $request->session()->put('isAdmin', $isAdmin);
        $isHospital=$user_type_id == 2;
        $request->session()->put('isHospital', $isHospital);
        $isBranch=$user_type_id == 4;
        $request->session()->put('isBranch', $isBranch);
        $isDoctor=$user_type_id == 5;
        $request->session()->put('isDoctor', $isDoctor);
        $isAdminHospital=($user_type_id == 1 || $user_type_id == 2);
        $request->session()->put('isAdminHospital', $isAdminHospital);
        $isNotAdmin=($user_type_id == 2 || $user_type_id == 3 || $user_type_id == 4 || $user_type_id == 5);
        $request->session()->put('isNotAdmin', $isNotAdmin);
        $isHospitalBranch=($user_type_id == 2 || $user_type_id == 4);
        $request->session()->put('isHospitalBranch', $isHospitalBranch);
        $isAdminHospitalBranch=($user_type_id == 1 || $user_type_id == 2 || $user_type_id == 4);
        $request->session()->put('isAdminHospitalBranch', $isAdminHospitalBranch);
    }
}