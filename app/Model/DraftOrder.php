<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class DraftOrder extends Model
{
    protected $fillable = [
        'user_id', 'portfolio_management_id', 'price', 'tracking_code'
    ];

    public function setPriceAttribute($value)
    {
        $this->attributes['price'] = str_replace(',', '', $value);
    }

    public function scopeDraftOrder($query)
    {
        return $query->leftjoin('users', 'users.id', '=', 'draft_orders.customer_id')
            ->leftjoin('portfolio_managements', 'portfolio_managements.id', '=', 'draft_orders.portfolio_management_id')
            ->select([
                'draft_orders.user_id',
                'users.name',
                'draft_orders.portfolio_management_id',
                'portfolio_managements.title as portfolio_management_title',
                'portfolio_managements.avatar',
                'draft_orders.price',
                'draft_orders.tracking_code'
            ]);
    }
}
