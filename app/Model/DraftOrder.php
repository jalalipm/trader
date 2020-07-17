<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class DraftOrder extends Model
{
    protected $fillable = [
        'user_id', 'portfolio_management_id', 'price', 'tracking_code'
    ];
}
