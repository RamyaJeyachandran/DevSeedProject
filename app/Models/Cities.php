<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\DB;

class Cities extends Model
{
    use HasFactory;
    protected $table = 'cities';
    protected $fillable = [
        'city_name',
        'city_state'
    ];
    public function getCities(){
        $cities=DB::table('cities')->select('city_state')
                                   ->groupby('city_state')
                                   ->orderby('city_state')
                                   ->get();
        return $cities;
    }
}
