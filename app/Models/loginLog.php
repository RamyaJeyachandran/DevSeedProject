<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;

class loginLog extends Model
{
    use HasApiTokens, HasFactory, Notifiable;
    public $timestamps = false;
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'loginUserId',
        'pageName',
    ];

    public function addLoginLog($userId,$pageName)
    {
        return static::create(
            [
                'loginUserId' => $userId,
                'pageName' => $pageName,
            ]
        );
    }
}
