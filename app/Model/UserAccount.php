<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class UserAccount extends Model
{

    const INTEREST = 1;
    const LOSS = 2;
    const REFUND = 3;
    const PAYMENT = 4;

    const CREDIT = 1;
    const DEBIT = 2;

    protected $fillable = [
        'payment_id', 'user_id', 'portfolio_management_id', 'price', 'payment_kind', 'payment_type', 'transaction_date'
    ];

    public function scopeGetByUserID($query, $user_id)
    {
        return $query->leftjoin('users', 'users.id', '=', 'user_accounts.user_id')
            ->leftjoin('portfolio_managements', 'portfolio_managements.id', '=', 'user_accounts.portfolio_management_id')
            ->leftjoin('payments', 'payments.id', '=', 'user_accounts.payment_id')
            ->where('user_accounts.user_id', $user_id)
            ->select([
                'user_accounts.id',
                'user_accounts.payment_id',
                'payments.ref_id',
                'user_accounts.user_id',
                'user_accounts.portfolio_management_id',
                'portfolio_managements.title as portfolio_management_title',
                'user_accounts.price',
                'user_accounts.payment_kind',
                'user_accounts.payment_type',
                DB::raw("case when payment_type = 1 then 'سود'
                                when payment_type = 2 then 'زیان'
                                when payment_type = 3 then 'تسویه'
                                else 'خرید' end as payment_type_title"),
                'user_accounts.transaction_date',
                DB::raw("pdate(user_accounts.transaction_date) as shamsi_transaction_date"),
            ]);
    }

    public function scopeGetByPortfolio($query, $user_id, $portfolio_management_id)
    {
        return $query->leftjoin('users', 'users.id', '=', 'user_accounts.user_id')
            ->where('user_accounts.user_id', $user_id)
            ->where('user_accounts.portfolio_management_id', $portfolio_management_id)
            ->select([
                'user_accounts.id',
                'user_accounts.payment_id',
                'user_accounts.user_id',
                'user_accounts.portfolio_management_id',
                'user_accounts.price',
                'user_accounts.payment_kind',
                'user_accounts.payment_type',
                'user_accounts.transaction_date'
            ]);
    }
}
