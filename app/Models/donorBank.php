<?php

namespace App\Models;

use config\constants;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class donorBank extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'donorbanks';
    protected $fillable = [
        'name',
        'address',
        'hospitalId',
        'branchId',
        'is_active',
        'created_by',
        'updated_by',
    ];
    public function getAllDonorBank($hospitalId,$branchId,$pagination)
    {
        $skip=$pagination['page'] ==1 ?0:(($pagination['page'] * $pagination['size'])-$pagination['size']);
        $where_sts="is_active=1 ".($hospitalId==0?"":" and hospitalId=".$hospitalId).($branchId==0?"":" and branchId=".$branchId);

        $donorBankList['donorBankList']=DB::table('donorbanks')->selectRaw("HEX(AES_ENCRYPT(id,UNHEX(SHA2('".config('constant.mysql_custom_encrypt_key')."',512)))) as id,name,address")
                                    ->whereRaw($where_sts)
                                    ->skip($skip)->take($pagination['size']) //pagination
                                    ->orderBy($pagination['sorters_field'],$pagination['sorters_dir']) 
                                   ->get();
        $lastPage=$donorBankList['donorBankList']->count();

        $donorBankList['last_page']=ceil($lastPage/$pagination['size']);

        return $donorBankList;
    }
    public static function addDonorBank(Request $request,$hospitalId,$branchId,$userId){
        return static::create(
            [
             'name' => $request->name,
             'address'=>$request->address,
             'hospitalId'=>$hospitalId,
             'branchId'=>$branchId,
             'created_by'=>$userId
            ]
        );
    }
    public static function updateDonorBank(Request $request,$userId){
        $donorId="AES_DECRYPT(UNHEX('".$request->donorId."'), UNHEX(SHA2('".config('constant.mysql_custom_encrypt_key')."',512)))";
        $where_sts="id=".$donorId;

        return static::whereRaw($where_sts)->update(
            [
             'name' => $request->name,
             'address'=>$request->address,
             'updated_by'=>$userId
            ]
        );
    }
    public function deleteDonorBankById($id,$userId)
    {
        $donorId="AES_DECRYPT(UNHEX('".$id."'), UNHEX(SHA2('".config('constant.mysql_custom_encrypt_key')."',512)))";
        $where_sts="id=".$donorId;
        $user = new User;
        $orignal_userId=$user->getDecryptedId($userId);
        
        return static::whereRaw($where_sts)->update(
            [
             'is_active'=>0,
             'updated_by'=>$orignal_userId
            ]
        );

    }  
    public function getDonorBankByHospital($hospitalId,$branchId)
    {
        $user = new User;
        $orignal_hospitalId=$user->getDecryptedId($hospitalId);
        $orignal_branchId=$user->getDecryptedId($branchId);

        $where_sts="is_active=1 ".($orignal_hospitalId==0?"":" and hospitalId=".$orignal_hospitalId).($orignal_branchId==0?"":" and branchId=".$orignal_branchId);

        $donorBankList=DB::table('donorbanks')->selectRaw("HEX(AES_ENCRYPT(id,UNHEX(SHA2('".config('constant.mysql_custom_encrypt_key')."',512)))) as id,name,address")
                                    ->whereRaw($where_sts)
                                    ->orderBy('name','asc') 
                                   ->get();

        return $donorBankList;
    }
}
