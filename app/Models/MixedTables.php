<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\DB;
use config\constant;

class MixedTables extends Model
{
    use HasFactory;
    protected $table = 'constants';
   
    public function getGender(){
        $gender=DB::table('constants')->select('id','name')
                                    ->where('parentTableId','=',config('constant.genderTableId'))
                                   ->get();
        return $gender;
    }
    public function getMartialStatus(){
        $martialStatus=DB::table('constants')->select('id','name')
                                    ->where('parentTableId','=',config('constant.martialStatusTableId'))
                                   ->get();
        return $martialStatus;
    }
    public function getRefferedBy(){
        $refferedBy=DB::table('constants')->select('id','name')
                                    ->where('parentTableId','=',config('constant.refferedByTableId'))
                                   ->get();
        return $refferedBy;
    }
    public function getBloodGrp(){
        $bloodGrp=DB::table('constants')->select('id','name')
                                    ->where('parentTableId','=',config('constant.bloodGrpTableId'))
                                   ->get();
        return $bloodGrp;
    }
    public function getDepartment(){
        $department=DB::table('departments')->select('id','name')
                                    ->where('is_active','=',1)
                                   ->get();
        return $department;
    }
}
