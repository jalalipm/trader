<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class UserBankAccount extends Model
{
    protected $fillable = [
        'user_id', 'account_holder', 'card_number', 'bank_name', 'iban'
    ];
}
