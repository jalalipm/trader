<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Payment extends Model
{
    protected $fillable = [
        'user_id', 'ref_id', 'amount', 'currency', 'reference_number', 'callback_url', 'status', 'init_payer_ip',
        'redirect_payer_ip', 'transaction_date', 'payer_card', 'payer_name', 'payment_kind', 'is_success',
        'description'
    ];

    public function scopePayment($query)
    {
        return $query->leftjoin('users', 'users.id', '=', 'payments.user_id')
            ->select([
                'payments.id',
                'payments.user_id',
                'users.name as full_name',
                'payments.ref_id',
                'payments.amount',
                'payments.currency',
                'payments.reference_number',
                'payments.callback_url',
                'payments.status',
                'payments.init_payer_ip',
                'payments.redirect_payer_ip',
                'payments.transaction_date',
                DB::raw("pdate(payments.transaction_date) as shamsi_transaction_date"),
                'payments.payer_card',
                'payments.payer_name',
                'payments.payment_kind',
                'payments.is_success',
                'payments.description'
            ]);
    }
}
