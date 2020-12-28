<?php

namespace App;

use App\Model\UserDocument;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable;

    const USER = 1;
    const ADMIN = 2;

    protected $fillable = [
        'name', 'email', 'password', 'national_code', 'first_name',
        'last_name', 'address', 'cell_phone', 'status', 'postal_code', 'avatar', 'push_id', 'kind'

    ];


    protected $hidden = [
        'password', 'remember_token',
    ];


    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function UserDocuments()
    {
        return $this->hasMany(UserDocument::class, 'user_id', 'id');
    }

    public function getStatusAttribute($value)
    {
        switch ($value) {
            case 'not_send':
                return 1;
                break;
            case 'pending':
                return 2;
                break;
            case 'approved':
                return 3;
                break;
        }
    }

    public function scopeUser($query)
    {
        return $query
            ->select([
                'id',
                'name',
                'email',
                'password',
                'national_code',
                'first_name',
                'last_name',
                'address',
                'cell_phone',
                'status',
                'push_id',
                'kind',
                DB::raw("case when status = 1 then 'ارسال نشده'
                                when status = 2 then 'درحال بررسی'
                                else 'تایید شده' end as status_title"),
                'postal_code',
                'avatar'
            ]);
    }
}
