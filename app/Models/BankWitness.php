<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class BankWitness extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'bank_witnesses';
    protected $fillable = [
        'name',
        'hospitalName',
        'phoneNo',
        'email',
        'address',
        'hospitalId',
        'branchId',
        'is_active',
        'created_by',
        'updated_by',
    ];
    public function getAllBankWitness($hospitalId,$branchId,$pagination)
    {
        $skip=$pagination['page'] ==1 ?0:(($pagination['page'] * $pagination['size'])-$pagination['size']);
        $where_sts="is_active=1 ".($hospitalId==0?"":" and hospitalId=".$hospitalId).($branchId==0?"":" and branchId=".$branchId);

        $witnessList['witnessList']=DB::table('bank_witnesses')->selectRaw("HEX(AES_ENCRYPT(id,UNHEX(SHA2('".config('constant.mysql_custom_encrypt_key')."',512)))) as id,name,hospitalName,phoneNo,email,address")
                                    ->whereRaw($where_sts)
                                    ->skip($skip)->take($pagination['size']) //pagination
                                    ->orderBy($pagination['sorters_field'],$pagination['sorters_dir']) 
                                   ->get();
        $lastPage=$witnessList['witnessList']->count();

        $witnessList['last_page']=ceil($lastPage/$pagination['size']);

        return $witnessList;
    }
    public static function addWitness($request,$hospitalId,$branchId,$userId){
        return static::create(
            [
             'name' => $request->name,
             'hospitalName' => $request->hospitalName,
             'phoneNo' => $request->phoneNo,
             'email' => $request->email,
             'address'=>$request->address,
             'hospitalId'=>$hospitalId,
             'branchId'=>$branchId,
             'created_by'=>$userId
            ]
        );
    }
    public static function updateWitness($request,$userId){
        $witnessId="AES_DECRYPT(UNHEX('".$request->witnessId."'), UNHEX(SHA2('".config('constant.mysql_custom_encrypt_key')."',512)))";

        return static::where('id','=',$witnessId)->update(
            [
                'name' => $request->name,
                'hospitalName' => $request->hospitalName,
                'phoneNo' => $request->phoneNo,
                'email' => $request->email,
                'address'=>$request->address,
                'updated_by'=>$userId
            ]
        );
    }
    public function deleteWitnessById($id,$userId)
    {
        $witnessId="AES_DECRYPT(UNHEX('".$id."'), UNHEX(SHA2('".config('constant.mysql_custom_encrypt_key')."',512)))";
        $user = new User;
        $orignal_userId=$user->getDecryptedId($userId);
        
        return static::where('id','=',$witnessId)->update(
            [
             'is_active'=>0,
             'updated_by'=>$orignal_userId
            ]
        );

    }  
    public function getBankWitnessByHospital($hospitalId,$branchId)
    {
        $user = new User;
        $orignal_hospitalId=$user->getDecryptedId($hospitalId);
        $orignal_branchId=$user->getDecryptedId($branchId);

        $where_sts="is_active=1 ".($orignal_hospitalId==0?"":" and hospitalId=".$orignal_hospitalId).($orignal_branchId==0?"":" and branchId=".$orignal_branchId);

        $donorBankList=DB::table('bank_witnesses')->selectRaw("HEX(AES_ENCRYPT(id,UNHEX(SHA2('".config('constant.mysql_custom_encrypt_key')."',512)))) as id,name,hospitalName,address")
                                    ->whereRaw($where_sts)
                                    ->orderBy('name','asc') 
                                   ->get();

        return $donorBankList;
    }
}
