<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $fillable = [
        'user_id', 'ref_id', 'amount', 'currency', 'reference_number', 'callback_url', 'status', 'init_payer_ip',
        'redirect_payer_ip', 'transaction_date', 'payer_card', 'payer_name', 'payment_kind', 'is_success',
        'description'
    ];
}
