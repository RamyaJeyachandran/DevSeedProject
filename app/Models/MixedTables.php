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

    public function getConsantValue($parentTableId)
    {
        return DB::table('constants')->select('id', 'name')->where('parentTableId', '=', $parentTableId)->get();
    }
    public function getDepartment()
    {
        $department = DB::table('departments')->select('id', 'name')
            ->where('is_active', '=', 1)
            ->get();
        return $department;
    }
}
