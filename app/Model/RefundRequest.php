<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class RefundRequest extends Model
{
    protected $fillable = [
        'user_id', 'portfolio_management_id', 'price', 'status', 'transaction_date', 'request_date', 'comment'
    ];

    const PROCESSING = 1;
    const CANCELED = 2;
    const DOING = 3;
    const DONE = 4;

    const STATUS_LIST = [
        1 => 'در حال بررسی',
        2 => 'انصراف',
        3 => 'در حال انجام',
        4 => 'انجام شده',
    ];

    public function setPriceAttribute($value)
    {
        $this->attributes['price'] = str_replace(',', '', $value);
    }

    public function getStatusAttribute($value)
    {
        switch ($value) {
            case 'processing':
                return 1;
                break;
            case 'canceled':
                return 2;
                break;
            case 'doing':
                return 3;
                break;
            case 'done':
                return 4;
                break;
        }
    }

    public function scopeRefundRequest($query)
    {
        return $query->leftjoin('portfolio_managements', 'portfolio_managements.id', '=', 'refund_requests.portfolio_management_id')
            ->leftjoin('users', 'users.id', '=', 'refund_requests.user_id')
            ->select([
                'refund_requests.id',
                'refund_requests.user_id',
                'users.name as full_name',
                'refund_requests.portfolio_management_id',
                'portfolio_managements.title as portfolio_management_title',
                'refund_requests.price',
                'refund_requests.status',
                'refund_requests.request_date',
                DB::raw("pdate(refund_requests.request_date) as shamsi_request_date"),
                'refund_requests.transaction_date',
                DB::raw("pdate(refund_requests.transaction_date) as shamsi_transaction_date"),
                DB::raw("case when refund_requests.status = 1 then 'در حال بررسی'
                                when refund_requests.status = 2 then 'انصراف'
                                when refund_requests.status = 3 then 'در حال انجام'
                                else 'انجام شده' end as status_title"),
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
                'refund_requests.request_date',
                'refund_requests.comment'
            ]);
    }
}
