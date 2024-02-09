<?php

namespace App\Models;

use Carbon\Carbon;
use config\constants;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Chat extends Model
{
    public $timestamps = false;
    use HasFactory;
    protected $table = 'chats';
    protected $fillable = [
        'sendMsg',
        'replyMsg',
        'is_active',
        'created_by',
        'updated_by',
    ];
    public static function addChat($userId,$sendMsg,$replyMsg){
        return static::create(
            ['sendMsg'=>$sendMsg,
             'replyMsg' => $replyMsg,
             'created_by'=>$userId
            ]
        );
    }
    public static function getChatHistory($userId)
    {
        // $user = new User;
        // $user_id=$user->getDecryptedId($userId);
        $chatDetails=DB::table('chats')->selectRaw("ROW_NUMBER() OVER (PARTITION BY DATE(created_date) ORDER BY created_date asc) as sNo,DATE_FORMAT(created_date,'%d %M %Y') as created_date, DATE_FORMAT(created_date,'%h:%i %p') as created_time,sendMsg,replyMsg")
                                    ->where([['is_active','=',1],['created_by','=',$userId]])
                                    ->get();

        return $chatDetails;
    }
}
