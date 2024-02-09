<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class NormalValues extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'normal_values';
    protected $fillable = [
        'liquefaction' ,
        'apperance',
        'ph',
        'volume',
        'viscosity',
        'abstinence',
        'medication',
        'spermConcentration',
        'agglutination',
        'clumping',
        'granularDebris',
        'totalMotility',
        'rapidProgressiveMovement',
        'sluggishProgressiveMovement',
        'nonProgressive',
        'nonMotile',
        'normalSperms',
        'headDefects',
        'neckMidPieceDefects',
        'tailDeffects',
        'cytoplasmicDroplets',
        'epithelialCells',
        'pusCells',
        'RBC',
        'hospitalId',
        'branchId',
        'is_active',
        'created_by',
        'updated_by',
    ];   
    public function getNormalValueByHospital($hospitalId,$branchId)
    {
        $where_sts="is_active=1 and hospitalId=".$hospitalId.($branchId==0|| $branchId==null?"":" and branchId=".$branchId);
        $normal_value=DB::table('normal_values')->selectRaw("HEX(AES_ENCRYPT(id,UNHEX(SHA2('".config('constant.mysql_custom_encrypt_key')."',512)))) as normalValueId,liquefaction,apperance,ph,volume,viscosity,abstinence,medication,spermConcentration,agglutination,clumping,granularDebris,totalMotility,rapidProgressiveMovement,sluggishProgressiveMovement,nonProgressive,nonMotile,normalSperms,headDefects,neckMidPieceDefects,tailDeffects,cytoplasmicDroplets,epithelialCells,pusCells,RBC")
                                    ->whereRaw($where_sts)
                                   ->first();
        if($normal_value==null)
        {
            $query_sts = "SELECT HEX(AES_ENCRYPT(0,UNHEX(SHA2('".config('constant.mysql_custom_encrypt_key')."',512)))) as normalValueId,'".config('constant.normalValue.liquefaction')."' as liquefaction,'".config('constant.normalValue.apperance')."' as apperance,'".config('constant.normalValue.ph')."' as ph,'".config('constant.normalValue.volume')."' as volume,'".config('constant.normalValue.viscosity')."' as viscosity,'".config('constant.normalValue.abstinence')."' as abstinence,'".config('constant.normalValue.medication')."' as medication,'".config('constant.normalValue.spermConcentration')."' as spermConcentration,'".config('constant.normalValue.agglutination')."' as agglutination,'".config('constant.normalValue.clumping')."' as clumping,'".config('constant.normalValue.granularDebris')."' as granularDebris,'".config('constant.normalValue.totalMotility')."' as totalMotility,'".config('constant.normalValue.rapidProgressiveMovement')."' as rapidProgressiveMovement,'".config('constant.normalValue.sluggishProgressiveMovement')."' as sluggishProgressiveMovement,'".config('constant.normalValue.nonProgressive')."' as nonProgressive,'".config('constant.normalValue.nonMotile')."' as nonMotile,'"
            .config('constant.normalValue.normalSperms')."' as normalSperms,'".config('constant.normalValue.headDefects')."' as headDefects,'".config('constant.normalValue.neckMidPieceDefects')."' as neckMidPieceDefects,'".config('constant.normalValue.tailDeffects')."' as tailDeffects,'"
            .config('constant.normalValue.cytoplasmicDroplets')."' as cytoplasmicDroplets,'".config('constant.normalValue.epithelialCells')."' as epithelialCells,'".config('constant.normalValue.pusCells')."' as pusCells,'".config('constant.normalValue.RBC')."' as RBC";
            $result = DB::select($query_sts);
            $normal_value=$result[0];
        }
        return $normal_value;
    }
    public static function updateNormalValue($request)
    {
        $user_obj = new User;
        $userId = $user_obj->getDecryptedId($request->userId);
        $normalValueId= $user_obj->getDecryptedId($request->normalValueId);
        $hospitalId=$user_obj->getDecryptedId($request->hospitalId);
        $branchId=$user_obj->getDecryptedId($request->branchId);
        $branchId=$branchId==0?NULL:$branchId;

        if($normalValueId>0)
        {
            return static::where('id',$normalValueId)->update(
                [
                    'liquefaction' =>$request->liquefaction,
                    'apperance'=> $request->apperance,
                    'ph' => $request->ph,
                    'volume'=>$request->volume,
                    'viscosity'=>$request->viscosity,
                    'abstinence'=>$request->abstinence,
                    'medication'=>$request->medication,
                    'spermConcentration'=>$request->spermConcentration,
                    'agglutination'=>$request->agglutination,
                    'clumping'=>$request->clumping,
                    'granularDebris'=>$request->granularDebris,
                    'totalMotility'=>$request->totalMotility,
                    'rapidProgressiveMovement'=>$request->rapidProgressiveMovement,
                    'sluggishProgressiveMovement'=>$request->sluggishProgressiveMovement,
                    'nonProgressive'=>$request->nonProgressive,
                    'nonMotile'=>$request->nonMotile,
                    'normalSperms'=>$request->normalSperms,
                    'headDefects'=>$request->headDefects,
                    'neckMidPieceDefects'=>$request->neckMidPieceDefects,
                    'tailDeffects'=>$request->tailDeffects,
                    'cytoplasmicDroplets'=>$request->cytoplasmicDroplets,
                    'epithelialCells'=>$request->epithelialCells,
                    'pusCells'=>$request->pusCells,
                    'RBC'=>$request->RBC,
                    'updated_by'=>$userId
                ]
            );
        }else{
            return static::create(
                [
                    'liquefaction' =>$request->liquefaction,
                    'apperance'=> $request->apperance,
                    'ph' => $request->ph,
                    'volume'=>$request->volume,
                    'viscosity'=>$request->viscosity,
                    'abstinence'=>$request->abstinence,
                    'medication'=>$request->medication,
                    'spermConcentration'=>$request->spermConcentration,
                    'agglutination'=>$request->agglutination,
                    'clumping'=>$request->clumping,
                    'granularDebris'=>$request->granularDebris,
                    'totalMotility'=>$request->totalMotility,
                    'rapidProgressiveMovement'=>$request->rapidProgressiveMovement,
                    'sluggishProgressiveMovement'=>$request->sluggishProgressiveMovement,
                    'nonProgressive'=>$request->nonProgressive,
                    'nonMotile'=>$request->nonMotile,
                    'normalSperms'=>$request->normalSperms,
                    'headDefects'=>$request->headDefects,
                    'neckMidPieceDefects'=>$request->neckMidPieceDefects,
                    'tailDeffects'=>$request->tailDeffects,
                    'cytoplasmicDroplets'=>$request->cytoplasmicDroplets,
                    'epithelialCells'=>$request->epithelialCells,
                    'pusCells'=>$request->pusCells,
                    'RBC'=>$request->RBC,
                    'hospitalId'=>$hospitalId,
                    'branchId'=>$branchId,
                    'created_by'=>$userId
                ]
            );
        }
    }
}
