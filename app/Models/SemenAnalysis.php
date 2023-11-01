<?php

namespace App\Models;

use Carbon\Carbon;
use config\constants;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class semenanalysis extends Model
{
    public $timestamps = false;
    use HasFactory;
    protected $table = 'semenanalysis';
    protected $fillable = [
        'liquefaction',
        'appearance',
        'ph',
        'volume',
        'viscosity',
        'abstinence',
        'medication',
        'spermconcentration',
        'agglutination',
        'clumping',
        'granulardebris',
        'totalmotility',
        'rapidprogressivemovement',
        'sluggishprogressivemovement',
        'nonprogressive',
        'nonmotile',
        'normalsperms',
        'headdefects',
        'neckandmidpiecedefects',
        'taildefects',
        'cytoplasmicdroplets',
        'epithelialcells',
        'puscells',
        'rbc',
        'impression',
        'comments',
        'patientId',
        'doctorId',
        'leftsigndoctorId',
        'centersigndoctorId',
        'rightsigndoctorId',
        'leftScientistId',
        'centerScientistId',
        'rightMedicalDirectorId',

        'is_active',
        'created_by',
        'updated_by'
    ];

    public function  getSemenAnalysisById($id)
    {
        $where_sts = "semenanalysis.id=" . $id;
        $semenanalysisDetails = DB::table('semenanalysis')->selectRaw("COALESCE(semenanalysis.liquefaction,0) as liquefaction,COALESCE(semenanalysis.appearance,0) as appearance,COALESCE(semenanalysis.ph,0) as ph,COALESCE(semenanalysis.volume,'') as volume,COALESCE(semenanalysis.viscosity,0) as viscosity,COALESCE(semenanalysis.abstinence,0) as abstinence,COALESCE(semenanalysis.medication,'') as medication,COALESCE(semenanalysis.spermconcentration,'') as spermconcentration,COALESCE(semenanalysis.agglutination,0) as agglutination,COALESCE(semenanalysis.clumping,0) as clumping,COALESCE(semenanalysis.granulardebris,0) as granulardebris,COALESCE(semenanalysis.totalmotility,'') as totalmotility,COALESCE(semenanalysis.rapidprogressivemovement,'') as rapidprogressivemovement,COALESCE(semenanalysis.sluggishprogressivemovement,'') as sluggishprogressivemovement, COALESCE(semenanalysis.nonprogressive,'') as nonprogressive,COALESCE(semenanalysis.nonmotile,'') as nonmotile,COALESCE(semenanalysis.normalsperms,'') as normalsperms,COALESCE(semenanalysis.headdefects,'') as headdefects,COALESCE(neckandmidpiecedefects,'') as neckandmidpiecedefects,COALESCE(semenanalysis.taildefects,'') as taildefects,COALESCE(semenanalysis.cytoplasmicdroplets,'') as cytoplasmicdroplets,COALESCE(semenanalysis.epithelialcells,0) as epithelialcells,COALESCE(semenanalysis.puscells,0) as puscells,COALESCE(semenanalysis.rbc,'') as rbc,COALESCE(semenanalysis.impression,'') as impression,COALESCE(semenanalysis.comments,'') as comments,HEX(AES_ENCRYPT(semenanalysis.patientId,UNHEX(SHA2('" . config('constant.mysql_custom_encrypt_key') . "',512)))) as patientId,HEX(AES_ENCRYPT(semenanalysis.doctorId,UNHEX(SHA2('" . config('constant.mysql_custom_encrypt_key') . "',512)))) as doctorId,HEX(AES_ENCRYPT(COALESCE(semenanalysis.leftsigndoctorId,0),UNHEX(SHA2('" . config('constant.mysql_custom_encrypt_key') . "',512)))) as leftsigndoctorId,HEX(AES_ENCRYPT(COALESCE(semenanalysis.centersigndoctorId,0),UNHEX(SHA2('" . config('constant.mysql_custom_encrypt_key') . "',512))))  as centersigndoctorId,HEX(AES_ENCRYPT(COALESCE(semenanalysis.rightsigndoctorId,0),UNHEX(SHA2('" . config('constant.mysql_custom_encrypt_key') . "',512))))  as rightsigndoctorId,HEX(AES_ENCRYPT(semenanalysis.id,UNHEX(SHA2('" . config('constant.mysql_custom_encrypt_key') . "',512)))) as semenanalysisId,HEX(AES_ENCRYPT(patients.hospitalId,UNHEX(SHA2('" . config('constant.mysql_custom_encrypt_key') . "',512)))) as hospitalId,HEX(AES_ENCRYPT(patients.branchId,UNHEX(SHA2('" . config('constant.mysql_custom_encrypt_key') . "',512)))) as branchId,patients.name,patients.hcNo,patients.spouseName,HEX(AES_ENCRYPT(semenanalysis.leftScientistId,UNHEX(SHA2('" . config('constant.mysql_custom_encrypt_key') . "',512)))) as leftScientistId,HEX(AES_ENCRYPT(semenanalysis.centerScientistId,UNHEX(SHA2('" . config('constant.mysql_custom_encrypt_key') . "',512)))) as centerScientistId,HEX(AES_ENCRYPT(semenanalysis.rightMedicalDirectorId,UNHEX(SHA2('" . config('constant.mysql_custom_encrypt_key') . "',512)))) as rightMedicalDirectorId")
            ->join("patients","patients.id","=","semenanalysis.patientId")
            ->whereRaw($where_sts)
            ->first();
        return $semenanalysisDetails;
    }
    public function  getSemenAnalysisByIdForPrint($id)
    {
        $where_sts = "semenanalysis.id=" . $id;
        $semenanalysisDetails = DB::table('semenanalysis')->selectRaw("COALESCE(semenanalysis.liquefaction,'') as liquefaction,
        COALESCE(semenanalysis.appearance,'') as appearance,
        COALESCE(semenanalysis.ph,'') as ph,
        COALESCE(semenanalysis.volume,'') as volume,
        COALESCE(semenanalysis.viscosity,'') as viscosity,
        COALESCE(semenanalysis.abstinence,'') as abstinence,
        COALESCE(semenanalysis.medication,'') as medication,
        COALESCE(semenanalysis.spermconcentration,'') as spermconcentration,
        COALESCE(semenanalysis.agglutination,'') as agglutination,
        COALESCE(semenanalysis.clumping,'') as clumping,
        COALESCE(semenanalysis.granulardebris,'') as granulardebris,
        COALESCE(semenanalysis.totalmotility,'') as totalmotility,
        COALESCE(semenanalysis.rapidprogressivemovement,'') as rapidprogressivemovement,
        COALESCE(semenanalysis.sluggishprogressivemovement,'') as sluggishprogressivemovement, 
        COALESCE(semenanalysis.nonprogressive,'') as nonprogressive,
        COALESCE(semenanalysis.nonmotile,'') as nonmotile,
        COALESCE(semenanalysis.normalsperms,'') as normalsperms,
        COALESCE(semenanalysis.headdefects,'') as headdefects,
        COALESCE(semenanalysis.neckandmidpiecedefects,'') as neckandmidpiecedefects,
        COALESCE(semenanalysis.taildefects,'') as taildefects,
        COALESCE(semenanalysis.cytoplasmicdroplets,'') as cytoplasmicdroplets,
        COALESCE(semenanalysis.epithelialcells,'') as epithelialcells,
        COALESCE(semenanalysis.puscells,'') as puscells,
        COALESCE(semenanalysis.rbc,'') as rbc,
        COALESCE(semenanalysis.impression,'') as impression,
        COALESCE(semenanalysis.comments,'') as comments,
        patients.name, 
        patients.hcNo,
        DATE_FORMAT(patients.dob, '%d-%m-%Y') as dob,
        patients.age,
        patients.gender,
        patients.spouseName,
        doctors.name as doctorName,
        DATE_FORMAT(patients.created_date, '%d-%m-%Y') as created_date
        ,COALESCE(leftSign.signature,'') as leftSignature,COALESCE(centerSign.signature,'') as centerSignature,COALESCE(rightSign.signature,'') as rightSignature
        ,COALESCE(leftDoctor.name,'') as leftDoctor,COALESCE(centerDoctor.name,'') as centerDoctor,COALESCE(rightDoctor.name,'') as rightDoctor")
            ->whereRaw($where_sts)
            ->join("patients","patients.id","=","semenanalysis.patientId")
            ->join("doctors","doctors.id","=","semenanalysis.doctorId")
            ->leftJoin('doctorsignatures as leftSign', 'semenanalysis.leftsigndoctorid','=','leftSign.id')
            ->leftJoin('doctorsignatures as centerSign', 'semenanalysis.centersigndoctorid','=','centerSign.id')
            ->leftJoin('doctorsignatures as rightSign', 'semenanalysis.rightsigndoctorid','=','rightSign.id')
            ->leftJoin('doctors as leftDoctor', 'semenanalysis.leftScientistId','=','leftDoctor.id')
            ->leftJoin('doctors as centerDoctor', 'semenanalysis.centerScientistId','=','centerDoctor.id')
            ->leftJoin('doctors as rightDoctor', 'semenanalysis.rightMedicalDirectorId','=','rightDoctor.id')
            ->first();
        return $semenanalysisDetails;
    }
    public function deleteSemenAnalysisById($id, $userId)
    {
        $user = new User;
        $semenanalysisiId = $user->getDecryptedId($id);
        $original_userId = $user->getDecryptedId($userId);

        return static::where('id',$semenanalysisiId)->update(
            [
                'is_active' => 0,
                'updated_by' => $original_userId
            ]
        );
    }
    public static function addSemenAnalysis(Request $request)
    {
        $user = new User;
        $userId = $user->getDecryptedId($request->userId);
        $patientId = $user->getDecryptedId($request->patientId);
        $doctorId=$user->getDecryptedId($request->doctorId);

        $liquefaction = (isset($request->liquefaction) && !empty($request->liquefaction)) ? $request->liquefaction : NULL;
        $appearance = (isset($request->appearance) && !empty($request->appearance)) ? $request->appearance : NULL;
        $ph = (isset($request->ph) && !empty($request->ph)) ? $request->ph : NULL;
        $volume = (isset($request->volume) && !empty($request->volume)) ? $request->volume : NULL;
        $viscosity = (isset($request->viscosity) && !empty($request->viscosity)) ? $request->viscosity : NULL;
        $abstinence = (isset($request->abstinence) && !empty($request->abstinence)) ? $request->abstinence : NULL;
        $medication = (isset($request->medication) && !empty($request->medication)) ? $request->medication : NULL;
        $spermconcentration = (isset($request->spermconcentration) && !empty($request->spermconcentration)) ? $request->spermconcentration : NULL;
        $agglutination = (isset($request->agglutination) && !empty($request->agglutination)) ? $request->agglutination : NULL;
        $clumping = (isset($request->clumping) && !empty($request->clumping)) ? $request->clumping : NULL;
        $granulardebris = (isset($request->granulardebris) && !empty($request->granulardebris)) ? $request->granulardebris : NULL;
        $totalmotility = (isset($request->totalmotility) && !empty($request->totalmotility)) ? $request->totalmotility : NULL;
        $rapidprogressivemovement = (isset($request->rapidprogressivemovement) && !empty($request->rapidprogressivemovement)) ? $request->rapidprogressivemovement : NULL;
        $sluggishprogressivemovement = (isset($request->sluggishprogressivemovement) && !empty($request->sluggishprogressivemovement)) ? $request->sluggishprogressivemovement : NULL;
        $nonprogressive = (isset($request->nonprogressive) && !empty($request->nonprogressive)) ? $request->nonprogressive : NULL;
        $nonmotile = (isset($request->nonmotile) && !empty($request->nonmotile)) ? $request->nonmotile : NULL;
        $normalsperms = (isset($request->normalsperms) && !empty($request->normalsperms)) ? $request->normalsperms : NULL;
        $headdefects = (isset($request->headdefects) && !empty($request->headdefects)) ? $request->headdefects : NULL;
        $neckandmidpiecedefects = (isset($request->neckandmidpiecedefects) && !empty($request->neckandmidpiecedefects)) ? $request->neckandmidpiecedefects : NULL;
        $taildefects = (isset($request->taildefects) && !empty($request->taildefects)) ? $request->taildefects : NULL;
        $cytoplasmicdroplets = (isset($request->cytoplasmicdroplets) && !empty($request->cytoplasmicdroplets)) ? $request->cytoplasmicdroplets : NULL;
        $epithelialcells = (isset($request->epithelialcells) && !empty($request->epithelialcells)) ? $request->epithelialcells : NULL;
        $puscells = (isset($request->puscells) && !empty($request->puscells)) ? $request->puscells : NULL;
        $rbc = (isset($request->rbc) && !empty($request->rbc)) ? $request->rbc : NULL;
        $impression = (isset($request->impression) && !empty($request->impression)) ? $request->impression : NULL;
        $comments = (isset($request->comments) && !empty($request->comments)) ? $request->comments : NULL;

        
        $leftsigndoctorId = (isset($request->leftsigndoctorId) && !empty($request->leftsigndoctorId)) ? $user->getDecryptedId($request->leftsigndoctorId) : NULL;
        $centersigndoctorId = (isset($request->centersigndoctorId) && !empty($request->centersigndoctorId)) ? $user->getDecryptedId($request->centersigndoctorId) : NULL;
        $rightsigndoctorId = (isset($request->rightsigndoctorId) && !empty($request->rightsigndoctorId)) ? $user->getDecryptedId($request->rightsigndoctorId) : NULL;

        $leftScientistId = (isset($request->leftScientistId) && !empty($request->leftScientistId)) ? $user->getDecryptedId($request->leftScientistId) : NULL;
        $centerScientistId = (isset($request->centerScientistId) && !empty($request->centerScientistId)) ? $user->getDecryptedId($request->centerScientistId) : NULL;
        $rightMedicalDirectorId = (isset($request->rightMedicalDirectorId) && !empty($request->rightMedicalDirectorId)) ? $user->getDecryptedId($request->rightMedicalDirectorId) : NULL;


        return static::create(
            [
                'liquefaction' => $liquefaction,
                'appearance' => $appearance,
                'ph' => $ph,
                'volume' => $volume,
                'viscosity' => $viscosity,
                'abstinence' => $abstinence,
                'medication' => $medication,
                'spermconcentration' => $spermconcentration,
                'agglutination' => $agglutination,
                'clumping' => $clumping,
                'granulardebris' => $granulardebris,
                'totalmotility' => $totalmotility,
                'rapidprogressivemovement' => $rapidprogressivemovement,
                'sluggishprogressivemovement' => $sluggishprogressivemovement,
                'nonprogressive' => $nonprogressive,
                'nonmotile' => $nonmotile,
                'normalsperms' => $normalsperms,
                'headdefects' => $headdefects,
                'neckandmidpiecedefects' => $neckandmidpiecedefects,
                'taildefects' => $taildefects,
                'cytoplasmicdroplets' => $cytoplasmicdroplets,
                'epithelialcells' => $epithelialcells,
                'puscells' => $puscells,
                'rbc' => $rbc,
                'impression' => $impression,
                'comments' => $comments,
                'patientId' => $patientId,
                'doctorId' => $doctorId,
                'leftsigndoctorId' => $leftsigndoctorId,
                'centersigndoctorId' => $centersigndoctorId,
                'rightsigndoctorId' => $rightsigndoctorId,
                'leftScientistId' => $leftScientistId,
                'centerScientistId' => $centerScientistId,
                'rightMedicalDirectorId' => $rightMedicalDirectorId,
                'created_by' => $userId
            ]
        );
    }
    public static function updateSemenAnalysis(Request $request)
    {
        $user = new User;
        $userId = $user->getDecryptedId($request->userId);
        $doctorId=$user->getDecryptedId($request->doctorId);

        $liquefaction = (isset($request->liquefaction) && !empty($request->liquefaction)) ? $request->liquefaction : NULL;
        $appearance = (isset($request->appearance) && !empty($request->appearance)) ? $request->appearance : NULL;
        $ph = (isset($request->ph) && !empty($request->ph)) ? $request->ph : NULL;
        $volume = (isset($request->volume) && !empty($request->volume)) ? $request->volume : NULL;
        $viscosity = (isset($request->viscosity) && !empty($request->viscosity)) ? $request->viscosity : NULL;
        $abstinence = (isset($request->abstinence) && !empty($request->abstinence)) ? $request->abstinence : NULL;
        $medication = (isset($request->medication) && !empty($request->medication)) ? $request->medication : NULL;
        $spermconcentration = (isset($request->spermconcentration) && !empty($request->spermconcentration)) ? $request->spermconcentration : NULL;
        $agglutination = (isset($request->agglutination) && !empty($request->agglutination)) ? $request->agglutination : NULL;
        $clumping = (isset($request->clumping) && !empty($request->clumping)) ? $request->clumping : NULL;
        $granulardebris = (isset($request->granulardebris) && !empty($request->granulardebris)) ? $request->granulardebris : NULL;
        $totalmotility = (isset($request->totalmotility) && !empty($request->totalmotility)) ? $request->totalmotility : NULL;
        $rapidprogressivemovement = (isset($request->rapidprogressivemovement) && !empty($request->rapidprogressivemovement)) ? $request->rapidprogressivemovement : NULL;
        $sluggishprogressivemovement = (isset($request->sluggishprogressivemovement) && !empty($request->sluggishprogressivemovement)) ? $request->sluggishprogressivemovement : NULL;
        $nonprogressive = (isset($request->nonprogressive) && !empty($request->nonprogressive)) ? $request->nonprogressive : NULL;
        $nonmotile = (isset($request->nonmotile) && !empty($request->nonmotile)) ? $request->nonmotile : NULL;
        $normalsperms = (isset($request->normalsperms) && !empty($request->normalsperms)) ? $request->normalsperms : NULL;
        $headdefects = (isset($request->headdefects) && !empty($request->headdefects)) ? $request->headdefects : NULL;
        $neckandmidpiecedefects = (isset($request->neckandmidpiecedefects) && !empty($request->neckandmidpiecedefects)) ? $request->neckandmidpiecedefects : NULL;
        $taildefects = (isset($request->taildefects) && !empty($request->taildefects)) ? $request->taildefects : NULL;
        $cytoplasmicdroplets = (isset($request->cytoplasmicdroplets) && !empty($request->cytoplasmicdroplets)) ? $request->cytoplasmicdroplets : NULL;
        $epithelialcells = (isset($request->epithelialcells) && !empty($request->epithelialcells)) ? $request->epithelialcells : NULL;
        $puscells = (isset($request->puscells) && !empty($request->puscells)) ? $request->puscells : NULL;
        $rbc = (isset($request->rbc) && !empty($request->rbc)) ? $request->rbc : NULL;
        $impression = (isset($request->impression) && !empty($request->impression)) ? $request->impression : NULL;
        $comments = (isset($request->comments) && !empty($request->comments)) ? $request->comments : NULL;

        $leftsigndoctorId = (isset($request->leftsigndoctorId) && !empty($request->leftsigndoctorId)) ? $user->getDecryptedId($request->leftsigndoctorId) : NULL;
        $centersigndoctorId = (isset($request->centersigndoctorId) && !empty($request->centersigndoctorId)) ? $user->getDecryptedId($request->centersigndoctorId) : NULL;
        $rightsigndoctorId = (isset($request->rightsigndoctorId) && !empty($request->rightsigndoctorId)) ? $user->getDecryptedId($request->rightsigndoctorId) : NULL;

        $leftScientistId = (isset($request->leftScientistId) && !empty($request->leftScientistId)) ? $user->getDecryptedId($request->leftScientistId) : NULL;
        $centerScientistId = (isset($request->centerScientistId) && !empty($request->centerScientistId)) ? $user->getDecryptedId($request->centerScientistId) : NULL;
        $rightMedicalDirectorId = (isset($request->rightMedicalDirectorId) && !empty($request->rightMedicalDirectorId)) ? $user->getDecryptedId($request->rightMedicalDirectorId) : NULL;



        $semenanalysisId = "AES_DECRYPT(UNHEX('" . $request->semenanalysisId . "'), UNHEX(SHA2('" . config('constant.mysql_custom_encrypt_key') . "',512)))";
        $where_sts = "id=" . $semenanalysisId;

        return static::whereRaw($where_sts)->update(
            [
                'liquefaction' => $liquefaction,
                'appearance' => $appearance,
                'ph' => $ph,
                'volume' => $volume,
                'viscosity' => $viscosity,
                'abstinence' => $abstinence,
                'medication' => $medication,
                'spermconcentration' => $spermconcentration,
                'agglutination' => $agglutination,
                'clumping' => $clumping,
                'granulardebris' => $granulardebris,
                'totalmotility' => $totalmotility,
                'rapidprogressivemovement' => $rapidprogressivemovement,
                'sluggishprogressivemovement' => $sluggishprogressivemovement,
                'nonprogressive' => $nonprogressive,
                'nonmotile' => $nonmotile,
                'normalsperms' => $normalsperms,
                'headdefects' => $headdefects,
                'neckandmidpiecedefects' => $neckandmidpiecedefects,
                'taildefects' => $taildefects,
                'cytoplasmicdroplets' => $cytoplasmicdroplets,
                'epithelialcells' => $epithelialcells,
                'puscells' => $puscells,
                'rbc' => $rbc,
                'impression' => $impression,
                'comments' => $comments,
                'doctorId'=> $doctorId,
                'leftsigndoctorId' => $leftsigndoctorId,
                'centersigndoctorId' => $centersigndoctorId,
                'rightsigndoctorId' => $rightsigndoctorId,
                'leftScientistId' => $leftScientistId,
                'centerScientistId' => $centerScientistId,
                'rightMedicalDirectorId' => $rightMedicalDirectorId,
                'updated_by' => $userId
            ]
        );
    }
    public static function getAllSemenAnalysis($hospitalId,$branchId,$pagination)
    {
        $skip=$pagination['page'] ==1 ?0:(($pagination['page'] * $pagination['size'])-$pagination['size']);
        if($pagination['filters_field']=='hcNo' || $pagination['filters_field']=='patientName' || $pagination['filters_field']=='phoneNo')
        {
            $pagination['filters_field']=($pagination['filters_field']=='patientName'?'name':$pagination['filters_field']);
            $wherePatient_sts="patients.is_active=1 ".($hospitalId==0?"":" and patients.hospitalId=".$hospitalId).($branchId==0?"":" and patients.branchId=".$branchId)." and patients.".$pagination['filters_field']." ".$pagination['filters_type'].($pagination['filters_type']=='like'?" '%":"").$pagination['filters_value'].($pagination['filters_type']=='like'?"%'":"");
            $where_sts="semenanalysis.is_active=1 ";
            $whereDoctor_sts="doctors.is_active=1";
        }
        else if($pagination["filters_field"]== "doctorName"){
            $where_sts="semenanalysis.is_active=1 ";
            $whereDoctor_sts="doctors.is_active=1 and doctors.name ".$pagination['filters_type'].($pagination['filters_type']=='like'?" '%":"").$pagination['filters_value'].($pagination['filters_type']=='like'?"%'":"");
            $wherePatient_sts="patients.is_active=1 ".($hospitalId==0?"":" and patients.hospitalId=".$hospitalId).($branchId==0?"":" and patients.branchId=".$branchId);
        }
        else{
            $wherePatient_sts="patients.is_active=1 ".($hospitalId==0?"":" and patients.hospitalId=".$hospitalId).($branchId==0?"":" and patients.branchId=".$branchId);
            $whereDoctor_sts="doctors.is_active=1";
            $where_sts="semenanalysis.is_active=1  ".(($pagination['filters_field'] =="" || $pagination['filters_value']=="")?"":" and ".($pagination['filters_field']=="created_date"?"semenanalysis.".$pagination['filters_field']:$pagination['filters_field'])." ".$pagination['filters_type']." ".($pagination['filters_field']=='created_date'?"'".Carbon::parse($pagination['filters_value'])->toDateString()."'":$pagination['filters_value']).($pagination['filters_field']=='created_date'?"":"%'"));
        }
       
        $semenAnalysisList['SemenAnalysisList']=DB::table('semenanalysis')->selectRaw("doctors.name as doctorName,patients.profileImage,patients.name as patientName,patients.hcNo,patients.email,patients.phoneNo,DATE_FORMAT(patients.created_date, '%d-%m-%Y') as created_date,HEX(AES_ENCRYPT(semenanalysis.id,UNHEX(SHA2('" . config('constant.mysql_custom_encrypt_key') . "',512)))) as id")
                                    ->join('doctors', function($join) use ($whereDoctor_sts)
                                        {
                                            $join->on('doctors.id', '=', 'semenanalysis.doctorId')
                                            ->whereRaw($whereDoctor_sts);
                                        })
                                    ->join('patients', function($join) use ($wherePatient_sts)
                                        {
                                        $join->on('patients.id', '=', 'semenanalysis.patientId')
                                            ->whereRaw($wherePatient_sts);
                                        })
                                    ->whereRaw($where_sts)
                                    ->skip($skip)->take($pagination['size']) //pagination
                                    ->orderBy($pagination['sorters_field'],$pagination['sorters_dir']) 
                                   ->get();
                                   
        $lastPage=DB::table('semenanalysis')->whereRaw($where_sts)->count();

        $semenAnalysisList['last_page']=ceil($lastPage/$pagination['size']);

        return $semenAnalysisList;
    }
}
