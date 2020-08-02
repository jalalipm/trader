<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class UserDocument extends Model
{
    protected $fillable = [
        'user_id', 'kind', 'pic_path', 'status', 'comment'
    ];

    public function getKindAttribute($value)
    {
        switch ($value) {
            case 'f_natioanl_card':
                return 1;
                break;
            case 'b_natioanl_card':
                return 2;
                break;
            case 'f_birth_certificate':
                return 3;
                break;
            case 'c_birth_certificate':
                return 4;
                break;
        }
    }

    public function getStatusAttribute($value)
    {
        switch ($value) {
            case 'pending':
                return 1;
                break;
            case 'approved':
                return 2;
                break;
            case 'rejected':
                return 3;
                break;
        }
    }
}
