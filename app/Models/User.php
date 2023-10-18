<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use config\constants;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    public $timestamps = false;
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'user_type_id',
        'is_login',
        'is_active',
        'user_id',
        'created_by'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        // 'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];
    public function createLogin($request, $userTypeTd, $id, $name)
    {
        $userId = $this->getDecryptedId($request->userId);

        $hashed = Hash::make($request->password, [
            'rounds' => 12,
        ]);
        return static::create(
            [
                'name' => $name,
                'email' => $request->email,
                'password' => $hashed,
                'user_type_id' => $userTypeTd,
                'created_by' => $userId,
                'user_id' => $id
            ]
        );
    }
    public function checkEmailId($email)
    {
        return DB::table('users')->where('name', '=', $email)
            ->where('is_active', '=', 1)->get();
    }
    public function getDecryptedId($encryptedId)
    {
        $select_sts = "SELECT AES_DECRYPT(UNHEX('" . $encryptedId . "'), UNHEX(SHA2('" . config('constant.mysql_custom_encrypt_key') . "',512))) as id";
        $result = DB::select($select_sts);
        return $result[0]->id;
    }
    public function getEncryptedId($id)
    {
        $select_sts = "SELECT HEX(AES_ENCRYPT(" . $id . ",UNHEX(SHA2('" . config('constant.mysql_custom_encrypt_key') . "',512)))) as id";
        $result = DB::select($select_sts);
        return $result[0]->id;
    }
    public function deleteLogin($userId, $userTypeTd, $loginUserId)
    {
        $original_loginUserId = $this->getDecryptedId($loginUserId);
        $original_UserId = $this->getDecryptedId($userId);

        return static::where([['user_id', '=', $original_UserId], ['user_type_id', '=', $userTypeTd]])->update(
            [
                'is_active' => 0,
                'updated_by' => $original_loginUserId
            ]
        );
    }
}