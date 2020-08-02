<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class UserAccount extends Model
{
    protected $fillable = [
        'payment_id', 'user_id', 'portfolio_management_id', 'price', 'payment_kind', 'payment_type', 'transaction_date'
    ];

    public function scopeGetByUserID($query, $user_id)
    {
        return $query->leftjoin('users', 'users.id', '=', 'user_accounts.user_id')
            ->leftjoin('portfolio_managements', 'portfolio_managements.id', '=', 'user_accounts.portfolio_management_id')
            ->where('user_accounts.user_id', $user_id)
            ->select([
                'user_accounts.id',
                'user_accounts.payment_id',
                'user_accounts.user_id',
                'user_accounts.portfolio_management_id',
                'portfolio_managements.title as portfolio_management_title',
                'user_accounts.price',
                'user_accounts.payment_kind',
                'user_accounts.payment_type',
                'user_accounts.transaction_date'
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
