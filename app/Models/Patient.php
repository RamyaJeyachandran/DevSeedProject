<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use config\constants;


class Patient extends Model
{
    public $timestamps = false;
    use HasFactory;
    protected $table = 'patients';
    protected $fillable = [
        'hcNo',
        'name',
        'profileImage',
        'dob',
        'age',
        'gender',
        'bloodGroup',
        'martialStatus',
        'patientWeight',
        'patientHeight',
        'phoneNo',
        'email',
        'address',
        'city',
        'state',
        'pincode',
        'spouseName',
        'spousePhnNo',
        'refferedBy',
        'refDoctorName',
        'refDrHospitalName',
        'reason',
        'hospitalId',
        'branchId',
        'is_active',
        'created_by',
        'updated_by'
    ];

    public static function addPatient(Request $request,$hcNo,$hospitalId,$branchId,$profileImage){
        $user = new User;
        $userId=$user->getDecryptedId($request->userId);

        $name=$request->name;
        $age=(isset($request->age) && !empty($request->age)) ?$request->age : NULL;
        $dob=(isset($request->dob) && !empty($request->dob)) ?date("Y-m-d", strtotime($request->dob)) : NULL;
        $gender=(isset($request->gender) && !empty($request->gender)) ?$request->gender : NULL;
        $bloodGrp=(isset($request->bloodGrp) && !empty($request->bloodGrp)) ?$request->bloodGrp : NULL;
        $martialStatus=(isset($request->martialStatus) && !empty($request->martialStatus)) ?$request->martialStatus : NULL;
        $weight=(isset($request->weight) && !empty($request->weight)) ?$request->weight : NULL;
        $height=(isset($request->height) && !empty($request->height)) ?$request->height : NULL;
        $phoneNo=$request->phoneNo;
        $email=$request->email;
        $address=(isset($request->address) && !empty($request->address)) ?$request->address : NULL;
        $city=(isset($request->city) && !empty($request->city)) ?$request->city : NULL;
        $state=(isset($request->state) && !empty($request->state)) ?$request->state : NULL;
        $pincode=(isset($request->pincode) && !empty($request->pincode)) ?$request->pincode : NULL;
        $spouseName=(isset($request->spouseName) && !empty($request->spouseName)) ?$request->spouseName : NULL;
        $spousePhnNo=(isset($request->spousePhnNo) && !empty($request->spousePhnNo)) ?$request->spousePhnNo : NULL;
        $refferedBy=(isset($request->refferedBy) && !empty($request->refferedBy)) ?$request->refferedBy : NULL;
        $docName=(isset($request->docName) && !empty($request->docName)) ?$request->docName : NULL;
        $docHpName=(isset($request->docHpName) && !empty($request->docHpName)) ?$request->docHpName : NULL;
        $reason=(isset($request->reason) && !empty($request->reason)) ?$request->reason : NULL;

        return static::create(
            ['hcNo'=>$hcNo,
             'name' => $name,
             'profileImage'=>$profileImage,
             'dob' => $dob,
             'age'=>$age,
             'gender'=>$gender,
             'bloodGroup'=>$bloodGrp,
             'martialStatus'=>$martialStatus,
             'patientWeight'=>$weight,
             'patientHeight'=>$height,
             'phoneNo'=>$phoneNo,
             'email'=>$email,
             'address'=>$address,
             'city'=>$city,
             'state'=>$state,
             'pincode'=>$pincode,
             'spouseName'=>$spouseName,
             'spousePhnNo'=>$spousePhnNo,
             'refferedBy'=>$refferedBy,
             'refDoctorName'=>$docName,
             'refDrHospitalName'=>$docHpName,
             'reason'=>$reason,
             'hospitalId'=>$hospitalId,
             'branchId'=>$branchId,
             'created_by'=>$userId
            ]
        );
    }
    public static function updatePatient(Request $request,$profileImage){
        $user = new User;
        $userId=$user->getDecryptedId($request->userId);

        $name=$request->name;
        $dob=(isset($request->dob) && !empty($request->dob)) ?date("Y-m-d", strtotime($request->dob)) : NULL;
        $age=(isset($request->age) && !empty($request->age)) ?$request->age : NULL;
        $gender=(isset($request->gender) && !empty($request->gender)) ?$request->gender : NULL;
        $bloodGrp=(isset($request->bloodGrp) && !empty($request->bloodGrp)) ?$request->bloodGrp : NULL;
        $martialStatus=(isset($request->martialStatus) && !empty($request->martialStatus)) ?$request->martialStatus : NULL;
        $weight=(isset($request->weight) && !empty($request->weight)) ?$request->weight : NULL;
        $height=(isset($request->height) && !empty($request->height)) ?$request->height : NULL;
        $phoneNo=$request->phoneNo;
        $email=$request->email;
        $address=(isset($request->address) && !empty($request->address)) ?$request->address : NULL;
        $city=(isset($request->city) && !empty($request->city)) ?$request->city : NULL;
        $state=(isset($request->state) && !empty($request->state)) ?$request->state : NULL;
        $pincode=(isset($request->pincode) && !empty($request->pincode)) ?$request->pincode : NULL;
        $spouseName=(isset($request->spouseName) && !empty($request->spouseName)) ?$request->spouseName : NULL;
        $spousePhnNo=(isset($request->spousePhnNo) && !empty($request->spousePhnNo)) ?$request->spousePhnNo : NULL;
        $refferedBy=(isset($request->refferedBy) && !empty($request->refferedBy)) ?$request->refferedBy : NULL;
        $docName=(isset($request->docName) && !empty($request->docName)) ?$request->docName : NULL;
        $docHpName=(isset($request->docHpName) && !empty($request->docHpName)) ?$request->docHpName : NULL;
        $reason=(isset($request->reason) && !empty($request->reason)) ?$request->reason : NULL;
        
        $patientId="AES_DECRYPT(UNHEX('".$request->patientId."'), UNHEX(SHA2('".config('constant.mysql_custom_encrypt_key')."',512)))";
        $where_sts="id=".$patientId;
        if($profileImage==""){        
                return static::whereRaw($where_sts)->update(
                    [
                    'name' => $name,
                    'dob' => $dob,
                    'age'=>$age,
                    'gender'=>$gender,
                    'bloodGroup'=>$bloodGrp,
                    'martialStatus'=>$martialStatus,
                    'patientWeight'=>$weight,
                    'patientHeight'=>$height,
                    'phoneNo'=>$phoneNo,
                    'email'=>$email,
                    'address'=>$address,
                    'city'=>$city,
                    'state'=>$state,
                    'pincode'=>$pincode,
                    'spouseName'=>$spouseName,
                    'spousePhnNo'=>$spousePhnNo,
                    'refferedBy'=>$refferedBy,
                    'refDoctorName'=>$docName,
                    'refDrHospitalName'=>$docHpName,
                    'reason'=>$reason,
                    'updated_by'=>$userId
                    ]
                );
        }else{
            return static::whereRaw($where_sts)->update(
                [
                'name' => $name,
                'dob' => $dob,
                'profileImage'=>$profileImage,
                'age'=>$age,
                'gender'=>$gender,
                'bloodGroup'=>$bloodGrp,
                'martialStatus'=>$martialStatus,
                'patientWeight'=>$weight,
                'patientHeight'=>$height,
                'phoneNo'=>$phoneNo,
                'email'=>$email,
                'address'=>$address,
                'city'=>$city,
                'state'=>$state,
                'pincode'=>$pincode,
                'spouseName'=>$spouseName,
                'spousePhnNo'=>$spousePhnNo,
                'refferedBy'=>$refferedBy,
                'refDoctorName'=>$docName,
                'refDrHospitalName'=>$docHpName,
                'reason'=>$reason,
                'updated_by'=>$userId
                ]
            );
        }
    }
    public static function generateHcNo($hospitalId){
        $hcNoList=DB::table('patients')->where('hospitalId','=',$hospitalId)->pluck('hcNo');
        do{
            $hcNo=random_int(10000,99999);
        }while($hcNoList->contains($hcNo));
        return $hcNo;
    }
    
    public static function checkPhoneNo($phoneNo,$hospitalId,$branchId){
        $phoneNoList=DB::table('patients')->select('hcNo')->where("phoneNo","=",$phoneNo)->where(function($q)use($phoneNo,$hospitalId,$branchId)  {
            $q
            ->Where("hospitalId","=",$hospitalId)
            ->orWhere("branchId","=",$branchId);
          })->first();
         return $phoneNoList; 
    }
    public static function checkPhoneNoById($phoneNo,$patientId){
        $where_sts="id <>".$patientId;
        $phoneNoList=DB::table('patients')->select('hcNo')->where("phoneNo","=",$phoneNo)->whereRaw($where_sts)->first();
         return $phoneNoList; 
    }

    public function getAllPatient($hospitalId,$branchId,$pagination)
    {
        $skip=$pagination['page'] ==1 ?0:(($pagination['page'] * $pagination['size'])-$pagination['size']);
        $where_sts="is_active=1 ".($hospitalId==0?"":" and hospitalId=".$hospitalId).($branchId==0?"":" and branchId=".$branchId)." ".(($pagination['filters_field'] =="" || $pagination['filters_value']=="")?"":" and ".$pagination['filters_field']." ".$pagination['filters_type']." '".$pagination['filters_value']."%'");

        $patientList['patientList']=DB::table('patients')->selectRaw("HEX(AES_ENCRYPT(id,UNHEX(SHA2('".config('constant.mysql_custom_encrypt_key')."',512)))) as id,hcNo,name,spouseName,bloodGroup,phoneNo,email,gender,profileImage")
                                    ->whereRaw($where_sts)
                                    ->skip($skip)->take($pagination['size']) //pagination
                                    ->orderBy($pagination['sorters_field'],$pagination['sorters_dir']) 
                                   ->get();
        $lastPage=DB::table('patients')->whereRaw($where_sts)->count();

        $patientList['last_page']=ceil($lastPage/$pagination['size']);

        return $patientList;
    }
    public function getPatientById($id)
    {
        $where_sts="id=".$id;
        $patientDetails=DB::table('patients')->selectRaw("COALESCE(age,0) as age,COALESCE(bloodGroup,0) as bloodGroup,COALESCE(dob,'') as dob,COALESCE(gender,0) as gender,COALESCE(martialStatus,0) as martialStatus,COALESCE(patientWeight,'') as weight,COALESCE(patientHeight,'') as height,COALESCE(address,'') as address,COALESCE(city,'') as city,COALESCE(state,'') as state,COALESCE(pincode,'') as pincode,COALESCE(spouseName,'') as spouseName,COALESCE(spousePhnNo,'') as spousePhnNo,COALESCE(refferedBy,'') as refferedBy,COALESCE(refDoctorName,'') as refDoctorName,COALESCE(refDrHospitalName,'') as refDrHospitalName,COALESCE(reason,'') as reason,COALESCE(hospitalId,'') as hospitalId,COALESCE(branchId,'') as branchId,COALESCE(is_active,'') as status,name,hcNo,phoneNo,email,HEX(AES_ENCRYPT(id,UNHEX(SHA2('".config('constant.mysql_custom_encrypt_key')."',512)))) as patientId,profileImage")
                                    ->whereRaw($where_sts)
                                   ->first();
        return $patientDetails;
    }
    public function deletePatientById($id,$userId)
    {
        $patientId="AES_DECRYPT(UNHEX('".$id."'), UNHEX(SHA2('".config('constant.mysql_custom_encrypt_key')."',512)))";
        $where_sts="id=".$patientId;
        $user = new User;
        $orignal_userId=$user->getDecryptedId($userId);
        
        return static::whereRaw($where_sts)->update(
            [
             'is_active'=>0,
             'updated_by'=>$orignal_userId
            ]
        );
    }   
    public function getPatientByHcNo($hcNo,$hospitalId,$branchId)
    {
        $user = new User;
        $decrypt_hospitalId=$user->getDecryptedId($hospitalId);
        $decrypt_branchId=$user->getDecryptedId($branchId);
        $decrypt_branchId=$decrypt_branchId==0?NULL:$decrypt_branchId;

        $where_sts="patients.is_active=1 and patients.hcNo=".$hcNo.($decrypt_hospitalId==0|| $decrypt_hospitalId==null?"":" and patients.hospitalId=".$decrypt_hospitalId).($decrypt_branchId==0|| $decrypt_branchId==null?"":" and patients.branchId=".$decrypt_branchId);
        if($decrypt_hospitalId==0 || $decrypt_hospitalId==null){
            $where_sts="patients.is_active=1 and patients.hcNo=".$hcNo;
        }

        $patientDetails=DB::table('patients')->selectRaw("COALESCE(patients.age,'Not Provided') as age,COALESCE(patients.bloodGroup,'Not Provided') as bloodGroup,COALESCE(patients.dob,'Not Provided') as dob,COALESCE(patients.gender,'Not Provided') as gender,COALESCE(patients.martialStatus,'Not Provided') as martialStatus,COALESCE(patients.patientWeight,'Not Provided') as weight,COALESCE(patients.patientHeight,'Not Provided') as height,COALESCE(patients.address,'Not Provided') as address,COALESCE(patients.city,'Not Provided') as city,COALESCE(patients.state,'Not Provided') as state,COALESCE(patients.pincode,'Not Provided') as pincode,COALESCE(patients.spouseName,'Not Provided') as spouseName,COALESCE(patients.spousePhnNo,'Not Provided') as spousePhnNo,COALESCE(patients.refferedBy,'Not Provided') as refferedBy,COALESCE(patients.refDoctorName,'Not Provided') as refDoctorName,COALESCE(patients.refDrHospitalName,'Not Provided') as refDrHospitalName,COALESCE(patients.reason,'Not Provided') as reason,COALESCE(patients.is_active,'Not Provided') as status,patients.name,patients.hcNo,patients.phoneNo,patients.email,HEX(AES_ENCRYPT(patients.id,UNHEX(SHA2('".config('constant.mysql_custom_encrypt_key')."',512)))) as patientId,COALESCE(hospitalbranch.branchName,hospitalsettings.hospitalName) as hospitalName,hospitalsettings.address as hospitalAddress,profileImage")
                                    ->join('hospitalsettings','hospitalsettings.id','=','patients.hospitalId')
                                    ->leftJoin('hospitalbranch','hospitalbranch.id','=','patients.branchId')
                                    ->whereRaw($where_sts)
                                   ->first();

        return $patientDetails;
    }
    public static function addAppointmentPatient(Request $request,$hcNo,$hospitalId,$branchId,$userId,$profileImage){
        $name=$request->patientName;
        $phoneNo=$request->phoneNo;
        $email=$request->email;
        $gender=(isset($request->gender) && !empty($request->gender)) ?$request->gender : NULL;
        $address=(isset($request->address) && !empty($request->address)) ?$request->address : NULL;
        $reason=$request->reason;
        $branchId=$branchId==0?NULL:$branchId;


        return static::create(
            [
             'hcNo'=>$hcNo,
             'name' => $name,
             'profileImage'=>$profileImage,
             'gender'=>$gender,
             'phoneNo'=>$phoneNo,
             'email'=>$email,
             'address'=>$address,
             'reason'=>$reason,
             'hospitalId'=>$hospitalId,
             'branchId'=>$branchId,
             'created_by'=>$userId
            ]
        );
    }
}
