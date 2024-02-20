<?php

namespace App\Models;

use Carbon\Carbon;
use config\constants;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


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
        'updated_by',
        'refferedByDoctorId',
        'witnessHospitalId',
        'witnessBankId',
        'aadharCardNo',
        'donorBankId'
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
        $aadharCardNo=(isset($request->aadharCardNo) && !empty($request->aadharCardNo)) ?$request->aadharCardNo : NULL;

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
             'aadharCardNo'=>$aadharCardNo,
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
        $aadharCardNo=(isset($request->aadharCardNo) && !empty($request->aadharCardNo)) ?$request->aadharCardNo : NULL;
        
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
                    'aadharCardNo'=>$aadharCardNo,
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
                'aadharCardNo'=>$aadharCardNo,
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
        $where_sts="patients.is_active=1 ".($hospitalId==0?"":" and patients.hospitalId=".$hospitalId).($branchId==0?"":" and patients.branchId=".$branchId)." ".(($pagination['filters_field'] =="" || $pagination['filters_value']=="")?"":" and patients.".$pagination['filters_field']." ".$pagination['filters_type']." '".$pagination['filters_value']."%'");
        $sorters_field="patients.".$pagination['sorters_field'];

        $patientList['patientList']=DB::table('patients')->selectRaw("HEX(AES_ENCRYPT(patients.id,UNHEX(SHA2('".config('constant.mysql_custom_encrypt_key')."',512)))) as id,hcNo,patients.name,patients.spouseName,patients.bloodGroup,patients.phoneNo,patients.email,patients.gender,patients.profileImage,doctors.profileImage as doctorImage,COALESCE(doctors.name,0) as doctorName,COALESCE(doctors.doctorCodeNo,0) as doctorCodeNo")
                                    ->leftJoin('doctors','doctors.id','=','patients.refferedByDoctorId')
                                    ->whereRaw($where_sts)
                                    ->skip($skip)->take($pagination['size']) //pagination
                                    ->orderBy($sorters_field,$pagination['sorters_dir']) 
                                   ->get();
        $lastPage=DB::table('patients')->whereRaw($where_sts)->count();

        $patientList['last_page']=ceil($lastPage/$pagination['size']);

        return $patientList;
    }
    public function getPatientById($id)
    {
        $where_sts="patients.id=".$id;
        $patientDetails=DB::table('patients')->selectRaw("COALESCE(patients.age,0) as age,COALESCE(patients.bloodGroup,0) as bloodGroup,COALESCE(patients.dob,'') as dob,COALESCE(patients.gender,0) as gender,COALESCE(patients.martialStatus,0) as martialStatus,COALESCE(patients.patientWeight,'') as weight,COALESCE(patients.patientHeight,'') as height,COALESCE(patients.address,'') as address,COALESCE(patients.city,'') as city,COALESCE(patients.state,'') as state,COALESCE(patients.pincode,'') as pincode,COALESCE(patients.spouseName,'Not Provided') as spouseName,COALESCE(patients.spousePhnNo,'') as spousePhnNo,COALESCE(patients.refferedBy,'') as refferedBy,COALESCE(patients.refDoctorName,'') as refDoctorName,COALESCE(patients.refDrHospitalName,'') as refDrHospitalName,COALESCE(reason,'') as reason,COALESCE(patients.hospitalId,'') as hospitalId,COALESCE(patients.branchId,'') as branchId,COALESCE(patients.is_active,'') as status,patients.name,patients.hcNo,patients.phoneNo,patients.email,HEX(AES_ENCRYPT(patients.id,UNHEX(SHA2('".config('constant.mysql_custom_encrypt_key')."',512)))) as patientId,patients.profileImage,HEX(AES_ENCRYPT(patients.refferedByDoctorId,UNHEX(SHA2('".config('constant.mysql_custom_encrypt_key')."',512)))) as refferedByDoctorId,HEX(AES_ENCRYPT(patients.witnessHospitalId,UNHEX(SHA2('".config('constant.mysql_custom_encrypt_key')."',512)))) as witnessHospitalId,HEX(AES_ENCRYPT(patients.witnessBankId,UNHEX(SHA2('".config('constant.mysql_custom_encrypt_key')."',512)))) as witnessBankId,HEX(AES_ENCRYPT(patients.hospitalId,UNHEX(SHA2('".config('constant.mysql_custom_encrypt_key')."',512)))) as dHopsitalId,HEX(AES_ENCRYPT(patients.branchId,UNHEX(SHA2('".config('constant.mysql_custom_encrypt_key')."',512)))) as dBranchId,CONCAT(COALESCE(doctors.name,''),' ',COALESCE(doctors.doctorCodeNo,'')) as attendingDoctor,CONCAT(COALESCE(refferedByDoc.name,''),' ',COALESCE(refferedByDoc.doctorCodeNo,'')) as refferedById,COALESCE(patients.aadharCardNo,'') as aadharCardNo,HEX(AES_ENCRYPT(patients.donorBankId,UNHEX(SHA2('".config('constant.mysql_custom_encrypt_key')."',512)))) as donorBankId")
                                    ->leftJoin('assign_doctors','assign_doctors.patientId','=','patients.id')
                                    ->leftJoin('doctors','doctors.id','=','assign_doctors.doctorId')
                                    ->leftJoin('doctors as refferedByDoc','refferedByDoc.id','=','patients.refferedByDoctorId')
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
    public function getPatientByPatientId($patientId,$hospitalId,$branchId)
    {
        $user = new User;
        $decrypt_hospitalId=$user->getDecryptedId($hospitalId);
        $decrypt_branchId=$user->getDecryptedId($branchId);
        $decrypt_branchId=$decrypt_branchId==0?NULL:$decrypt_branchId;

        $decrypt_patientId=$user->getDecryptedId($patientId);

        $where_sts="patients.is_active=1 and patients.id=".$decrypt_patientId.($decrypt_hospitalId==0|| $decrypt_hospitalId==null?"":" and patients.hospitalId=".$decrypt_hospitalId).($decrypt_branchId==0|| $decrypt_branchId==null?"":" and patients.branchId=".$decrypt_branchId);
        if($decrypt_hospitalId==0 || $decrypt_hospitalId==null){
            $where_sts="patients.is_active=1 and patients.id=".$decrypt_patientId;
        }

        $patientDetails=DB::table('patients')->selectRaw("COALESCE(patients.age,'Not Provided') as age,COALESCE(patients.bloodGroup,'Not Provided') as bloodGroup,COALESCE(patients.dob,'Not Provided') as dob,COALESCE(patients.gender,'Not Provided') as gender,COALESCE(patients.martialStatus,'Not Provided') as martialStatus,COALESCE(patients.patientWeight,'Not Provided') as weight,COALESCE(patients.patientHeight,'Not Provided') as height,COALESCE(patients.address,'Not Provided') as address,COALESCE(patients.city,'Not Provided') as city,COALESCE(patients.state,'Not Provided') as state,COALESCE(patients.pincode,'Not Provided') as pincode,COALESCE(patients.spouseName,'Not Provided') as spouseName,COALESCE(patients.spousePhnNo,'Not Provided') as spousePhnNo,COALESCE(patients.refferedBy,'Not Provided') as refferedBy,COALESCE(patients.refDoctorName,'Not Provided') as refDoctorName,COALESCE(patients.refDrHospitalName,'Not Provided') as refDrHospitalName,COALESCE(patients.reason,'Not Provided') as reason,COALESCE(patients.is_active,'Not Provided') as status,patients.name,patients.hcNo,patients.phoneNo,patients.email,HEX(AES_ENCRYPT(patients.id,UNHEX(SHA2('".config('constant.mysql_custom_encrypt_key')."',512)))) as patientId,COALESCE(hospitalbranch.branchName,hospitalsettings.hospitalName) as hospitalName,hospitalsettings.address as hospitalAddress,patients.profileImage,COALESCE(patients.aadharCardNo,'') as aadharCardNo,attendingDoc.name as attendingDoctor,counsellor.name as counsellor,witnessHosp.name as witnessHospital,witnessBank.name as witnessBank,donorbanks.name as donorBankName,donorbanks.address as donorBankAddress,COALESCE(witnessHosp.address,'') as witnessHospAddress,COALESCE(witnessBank.address,'') as witnessBankAddress,COALESCE(counsellor.address,'') as counsellorAddress,COALESCE(attendingDoc.address,'') as attendingDoctorAddress")
                                    ->join('hospitalsettings','hospitalsettings.id','=','patients.hospitalId')
                                    ->leftJoin('hospitalbranch','hospitalbranch.id','=','patients.branchId')
                                    ->leftJoin('assign_doctors','assign_doctors.patientId','=','patients.id')
                                    ->leftJoin('doctors as attendingDoc','attendingDoc.id','=','assign_doctors.doctorId')
                                    ->leftJoin('doctors as counsellor','counsellor.id','=','patients.refferedByDoctorId')
                                    ->leftJoin('doctors as witnessHosp','witnessHosp.id','=','patients.witnessHospitalId')
                                    ->leftJoin('bank_witnesses as witnessBank','witnessBank.id','=','patients.witnessBankId')
                                    ->leftJoin('donorbanks','donorbanks.id','=','patients.donorBankId')
                                    ->whereRaw($where_sts)
                                   ->first();

        return $patientDetails;
    }
    public function getPatientByHcNo($patientId,$hospitalId,$branchId)
    {
        $user = new User;
        $decrypt_hospitalId=$user->getDecryptedId($hospitalId);
        $decrypt_branchId=$user->getDecryptedId($branchId);
        $id=$user->getDecryptedId($patientId);
        $decrypt_branchId=$decrypt_branchId==0?NULL:$decrypt_branchId;

        $where_sts="patients.is_active=1 and patients.id=".$id.($decrypt_hospitalId==0|| $decrypt_hospitalId==null?"":" and patients.hospitalId=".$decrypt_hospitalId).($decrypt_branchId==0|| $decrypt_branchId==null?"":" and patients.branchId=".$decrypt_branchId);
        if($decrypt_hospitalId==0 || $decrypt_hospitalId==null){
            $where_sts="patients.is_active=1 and patients.id=".$id;
        }

        $patientDetails=DB::table('patients')->selectRaw("COALESCE(patients.age,'Not Provided') as age,COALESCE(patients.bloodGroup,'Not Provided') as bloodGroup,COALESCE(patients.dob,'Not Provided') as dob,COALESCE(patients.gender,'Not Provided') as gender,COALESCE(patients.martialStatus,'Not Provided') as martialStatus,COALESCE(patients.patientWeight,'Not Provided') as weight,COALESCE(patients.patientHeight,'Not Provided') as height,COALESCE(patients.address,'Not Provided') as address,COALESCE(patients.city,'Not Provided') as city,COALESCE(patients.state,'Not Provided') as state,COALESCE(patients.pincode,'Not Provided') as pincode,COALESCE(patients.spouseName,'Not Provided') as spouseName,COALESCE(patients.spousePhnNo,'Not Provided') as spousePhnNo,COALESCE(patients.refferedBy,'Not Provided') as refferedBy,COALESCE(patients.refDoctorName,'Not Provided') as refDoctorName,COALESCE(patients.refDrHospitalName,'Not Provided') as refDrHospitalName,COALESCE(patients.reason,'Not Provided') as reason,COALESCE(patients.is_active,'Not Provided') as status,patients.name,patients.hcNo,patients.phoneNo,patients.email,HEX(AES_ENCRYPT(patients.id,UNHEX(SHA2('".config('constant.mysql_custom_encrypt_key')."',512)))) as patientId,COALESCE(hospitalbranch.branchName,hospitalsettings.hospitalName) as hospitalName,hospitalsettings.address as hospitalAddress,patients.profileImage,COALESCE(patients.aadharCardNo,'') as aadharCardNo,attendingDoc.name as attendingDoctor,counsellor.name as counsellor,witnessHosp.name as witnessHospital,witnessBank.name as witnessBank,donorbanks.name as donorBankName,donorbanks.address as donorBankAddress,COALESCE(witnessHosp.address,'') as witnessHospAddress,COALESCE(witnessBank.address,'') as witnessBankAddress,COALESCE(counsellor.address,'') as counsellorAddress,COALESCE(attendingDoc.address,'') as attendingDoctorAddress")
                                    ->join('hospitalsettings','hospitalsettings.id','=','patients.hospitalId')
                                    ->leftJoin('hospitalbranch','hospitalbranch.id','=','patients.branchId')
                                    ->leftJoin('assign_doctors','assign_doctors.patientId','=','patients.id')
                                    ->leftJoin('doctors as attendingDoc','attendingDoc.id','=','assign_doctors.doctorId')
                                    ->leftJoin('doctors as counsellor','counsellor.id','=','patients.refferedByDoctorId')
                                    ->leftJoin('doctors as witnessHosp','witnessHosp.id','=','patients.witnessHospitalId')
                                    ->leftJoin('bank_witnesses as witnessBank','witnessBank.id','=','patients.witnessBankId')
                                    ->leftJoin('donorbanks','donorbanks.id','=','patients.donorBankId')
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
    public function getPatientByHospitalId($hospitalId,$branchId)
    {
        $user = new User;
        $decrypt_hospitalId=$user->getDecryptedId($hospitalId);
        $decrypt_branchId=$user->getDecryptedId($branchId);
        $decrypt_branchId=$decrypt_branchId==0?NULL:$decrypt_branchId;

        $where_sts="patients.is_active=1 and patients.hospitalId=".$decrypt_hospitalId.($decrypt_branchId==0|| $decrypt_branchId==null?"":" and patients.branchId=".$decrypt_branchId);

        $patientDetails=DB::table('patients')->selectRaw("HEX(AES_ENCRYPT(patients.id,UNHEX(SHA2('".config('constant.mysql_custom_encrypt_key')."',512)))) as id,CONCAT(patients.name,' - ',patients.hcNo) as name")
                                    ->join('hospitalsettings','hospitalsettings.id','=','patients.hospitalId')
                                    ->leftJoin('hospitalbranch','hospitalbranch.id','=','patients.branchId')
                                    ->whereRaw($where_sts)
                                   ->get();

        return $patientDetails;
    }
    public function getPatientDetailReport($request){
        $user = new User;
        $hospitalId=($request->hospitalId==NULL?$request->hospitalId:$user->getDecryptedId($request->hospitalId));
        $branchId=($request->branchId==NULL?$request->branchId:$user->getDecryptedId($request->branchId));
 
        $where_sts="patients.is_active=1 ".($hospitalId==0 || $hospitalId==null ?"":" and patients.hospitalId=".$hospitalId).($branchId==0|| $branchId==null?"":" and patients.branchId=".$branchId);

        if($request->dateRange!=null && $request->dateRange!= ""){
            $dateRange=explode("-",$request->dateRange);
            $where_sts= $where_sts. " and ( patients.created_date >= '".Carbon::parse($dateRange[0])->toDateString()."' and patients.created_date <= '".Carbon::parse($dateRange[1])->toDateString()."' )";
        }

        return DB::table('patients')->selectRaw("ROW_NUMBER() OVER(ORDER BY patients.id) as sNo,COALESCE(age,'') as age,COALESCE(patients.bloodGroup,'') as bloodGroup,COALESCE(patients.gender,'') as gender,COALESCE(martialStatus,'') as martialStatus,COALESCE(patientWeight,'') as weight,COALESCE(patientHeight,'') as height,COALESCE(spouseName,'') as spouseName,COALESCE(spousePhnNo,'') as spousePhnNo,patients.name,hcNo,patients.phoneNo,patients.email,patients.created_date,COALESCE(doctors.name,'') as assignedDoctor")
                                            ->leftJoin('assign_doctors','assign_doctors.patientId','=','patients.id')
                                            ->leftJoin('doctors','doctors.id','=','assign_doctors.doctorId')
                                            ->whereRaw($where_sts)
                                            ->get();
    }
    public static function updatePatientRefferedBy(Request $request){
        $user = new User;
        $userId=$user->getDecryptedId($request->userId);
        $refferedByDoctorId=$user->getDecryptedId($request->refferedByDoctorId);
        $witnessHospitalId=$user->getDecryptedId($request->witnessHospitalId);
        $witnessBankId=$user->getDecryptedId($request->witnessBankId);
        $donorBankId=$user->getDecryptedId($request->donorBankId);

        $patientId="AES_DECRYPT(UNHEX('".$request->patientId."'), UNHEX(SHA2('".config('constant.mysql_custom_encrypt_key')."',512)))";
        $where_sts="id=".$patientId;

                return static::whereRaw($where_sts)->update(
                    [
                    'witnessHospitalId'=>$witnessHospitalId,
                    'refferedByDoctorId'=>$refferedByDoctorId,
                    'witnessBankId'=>$witnessBankId,
                    'donorBankId'=>$donorBankId,
                    'updated_by'=>$userId
                    ]
                );
    }
}
