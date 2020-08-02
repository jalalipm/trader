<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class RefundRequest extends Model
{
    protected $fillable = [
        'user_id', 'portfolio_management_id', 'price', 'status', 'transaction_date', 'comment'
    ];

    public function scopeRefundRequest($query)
    {
        return $query->leftjoin('portfolio_managements', 'portfolio_managements.id', '=', 'refund_requests.portfolio_management_id')
            ->select([
                'refund_requests.id',
                'refund_requests.user_id',
                'refund_requests.portfolio_management_id',
                'portfolio_managements.title as portfolio_management_title',
                'refund_requests.price',
                'refund_requests.status',
                'refund_requests.transaction_date',
                'refund_requests.comment'
            ]);
    }

    public function scopeGetByUser($query, $user_id)
    {
        return $query->leftjoin('portfolio_managements', 'portfolio_managements.id', '=', 'refund_requests.portfolio_management_id')
            ->where('user_id', $user_id)
            ->select([
                'refund_requests.id',
                'refund_requests.user_id',
                'refund_requests.portfolio_management_id',
                'portfolio_managements.title as portfolio_management_title',
                'refund_requests.price',
                'refund_requests.status',
                'refund_requests.transaction_date',
                'refund_requests.comment'
            ]);
    }
}
