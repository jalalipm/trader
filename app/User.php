<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable;


    protected $fillable = [
        'name', 'email', 'password', 'national_code', 'first_name',
        'last_name', 'address', 'cell_phone', 'status', 'postal_code', 'avatar'

    ];


    protected $hidden = [
        'password', 'remember_token',
    ];


    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

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
}
