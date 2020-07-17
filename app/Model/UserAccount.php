<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class UserAccount extends Model
{
    protected $fillable = [
        'payment_id', 'portfolio_management_id', 'price', 'payment_kind', 'payment_type', 'transaction_date'
    ];
}
