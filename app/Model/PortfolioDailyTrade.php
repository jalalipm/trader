<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class PortfolioDailyTrade extends Model
{
    protected $table = 'portfolio_daily_trade';
    protected $fillable = [
        'trade_date', 'trade_nav', 'trade_percent', 'portfolio_management_id'
    ];

    public function setTradeNavAttribute($value)
    {
        $this->attributes['trade_nav'] = str_replace(',', '', $value);
    }

    public function setTradePercentAttribute($value)
    {
        $this->attributes['trade_percent'] = str_replace(',', '', $value);
    }

    public function scopeDailyTradeByPortfolioID($query, $portfolio_management_id)
    {
        return $query->leftjoin('portfolio_managements', 'portfolio_managements.id', '=', 'portfolio_daily_trade.portfolio_management_id')
            ->where('portfolio_management_id', $portfolio_management_id)
            ->select([
                'portfolio_daily_trade.id',
                'portfolio_daily_trade.portfolio_management_id',
                'portfolio_managements.title as portfolio_management_title',
                'portfolio_daily_trade.trade_nav',
                'portfolio_daily_trade.trade_percent',
                'portfolio_daily_trade.trade_date',
                DB::raw("pdate(portfolio_daily_trade.trade_date) as shamsi_trade_date"),
            ]);
    }
}
