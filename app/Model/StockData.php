<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class StockData extends Model
{
    protected $fillable = [
        'general_index', 'general_index_change', 'general_index_same_weight',
        'general_index_same_weight_change', 'market_value', 'transaction_count',
        'transaction_value', 'transaction_volume'
    ];
}
