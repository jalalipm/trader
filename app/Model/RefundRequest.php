<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class RefundRequest extends Model
{
    protected $fillable = [
        'user_id', 'portfolio_management_id', 'price', 'status', 'transaction_date', 'comment'
    ];
}
