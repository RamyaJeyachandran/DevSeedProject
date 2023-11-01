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
        'created_by'
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
    public function getEncryptedId($id)
    {
        $select_sts = "SELECT HEX(AES_ENCRYPT(" . $id . ",UNHEX(SHA2('" . config('constant.mysql_custom_encrypt_key') . "',512)))) as id";
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
        return DB::table('users')->selectRaw("HEX(AES_ENCRYPT(id,UNHEX(SHA2('".config('constant.mysql_custom_encrypt_key')."',512)))) as id,name,email")->where("id",$userId)->first();
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
                    $profileDetails= DB::table('hospitalSettings')->selectRaw("logo as Image,hospitalName as Name,address,phoneNo,email,inChargePerson,inChargePhoneNo,IF(is_subscribed=0,'No','Yes') as is_subscribed,HEX(AES_ENCRYPT(id,UNHEX(SHA2('".config('constant.mysql_custom_encrypt_key')."',512)))) as id")
                                                        ->where('id',$userInfo->user_id)
                                                        ->first();
                    break;
                case 4:
                    $profileDetails=DB::table('hospitalBranch')->selectRaw("hospitalBranch.logo  as Image,hospitalSettings.hospitalName,hospitalBranch.branchName as Name,hospitalBranch.address,hospitalBranch.phoneNo,hospitalBranch.email,hospitalBranch.contactPerson as inChargePerson,hospitalBranch.contactPersonPhNo as inChargePhoneNo,HEX(AES_ENCRYPT(hospitalBranch.hospitalId,UNHEX(SHA2('".config('constant.mysql_custom_encrypt_key')."',512)))) as hospitalId,HEX(AES_ENCRYPT(hospitalBranch.id,UNHEX(SHA2('".config('constant.mysql_custom_encrypt_key')."',512)))) as id")
                                                ->join('hospitalSettings', 'hospitalSettings.id', '=', 'hospitalBranch.hospitalId')
                                                ->where([['hospitalBranch.is_active','=',1],['hospitalBranch.id','=',$userInfo->user_id]])
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
}