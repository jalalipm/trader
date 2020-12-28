<?php

namespace App\Model;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class UserFinanceHistory extends Model
{
    protected $table = 'user_finance_history';
    protected $fillable = [
        'user_id',
        'portfolio_management_id',
        'trade_date',
        'fund',
        // 'before_percent_of_basket',
        'current_fund',
        'deposit',
        'withdraw',
        'pure_price',
        'percent_of_basket',
        'final_price'
    ];

    public function setTradeNavAttribute($value)
    {
        $this->attributes['trade_nav'] = str_replace(',', '', $value);
    }

    public function setTradePercentAttribute($value)
    {
        $this->attributes['trade_percent'] = str_replace(',', '', $value);
    }

    public function scopeCostBenefitReport($query)
    {
        return $query->leftjoin('portfolio_managements', 'portfolio_managements.id', '=', 'user_finance_history.portfolio_management_id')
            ->leftjoin('users', 'users.id', '=', 'user_finance_history.user_id')
            ->select([
                'user_finance_history.user_id',
                'users.name',
                'user_finance_history.portfolio_management_id',
                'portfolio_managements.title as portfolio_management',
                'user_finance_history.trade_date',
                DB::raw("pdate(user_finance_history.trade_date) as shamsi_trade_date"),
                'user_finance_history.fund',
                'user_finance_history.current_fund',
                DB::raw("round(current_fund - fund,0) as cost_benefit"),
                DB::raw("round(case when current_fund - fund > 0 then (current_fund - fund) * 0.2 else 0 end,0) as basket_commission"),
                DB::raw("round(current_fund - (case when current_fund - fund > 0 then (current_fund - fund) * 0.2 else 0 end),0) as remain_after_commission"),
                'user_finance_history.deposit',
                'user_finance_history.withdraw',
                DB::raw("round(ifnull(deposit,0) * 0.995 - ifnull(withdraw,0) * 1.01 + current_fund - 
                        (case when current_fund - fund > 0 then round((current_fund - fund) * 0.2,0) else 0 end),0) as withdrawable"),
                'user_finance_history.pure_price',
                'user_finance_history.percent_of_basket',
                'user_finance_history.final_price'
            ]);
    }

    public function scopeFinanceHistoryByPortfolio($query, $portfolio_management_id, $date)
    {
        $current_date = $date->toDateTimeString();
        $before_date = $date->subDay()->toDateTimeString();
        return DB::select(DB::raw("select total.user_id,total.name,total.portfolio_management_id,total.portfolio,total.trade_nav,total.fund,
                                    -- total.before_percent_of_basket,
                                    total.current_fund,
                                    -- سود و زیان
                                    (total.current_fund - total.fund) as cost_benefit,
                                    -- کارمزد سبد گردان
                                    (case when total.current_fund - total.fund > 0 then round((total.current_fund - total.fund) * 0.2,0) else 0 end) as basket_commission,
                                    -- مانده پس از کسر کارمزد
                                    total.current_fund - 
                                    (case when total.current_fund - total.fund > 0 then round((total.current_fund - total.fund) * 0.2,0) else 0 end) as remain_after_commission,
                                    -- واریز وجه 
                                    ifnull(ac.deposit,0) as deposit,
                                    -- برداشت وجه
                                    ifnull(ac.withdraw,0) as withdraw,
                                    -- قابل برداشت
                                    round(ifnull(ac.deposit,0) * 0.995 - ifnull(ac.withdraw,0) * 1.01 + 
                                    total.current_fund - 
                                    (case when total.current_fund - total.fund > 0 then round((total.current_fund - total.fund) * 0.2,0) else 0 end),0) as withdrawable,
                                    -- مبلغ خالص
                                    total.current_fund as pure_price,
                                    -- مبلغ نهایی
                                    total.current_fund as final_price
                                    from 
                                    (select ac.user_id,ac.name,ac.portfolio_management_id,ac.portfolio,ifnull(pdb.trade_nav,0) as trade_nav,
                                    -- سرمایه
                                    case 	when ac.user_id = 0 then (case  when ifnull(history.withdraw,0) > 0 then ifnull(history.fund - history.withdraw,ac.price) 
                                    												 else (case when ifnull(history.deposit,0) > 0 then (history.fund + history.deposit) 
                                    												 				else ifnull(history.fund,ac.price) end) end) - ifnull(total_deposit,0) + ifnull(total_withdraw,0) 
                                    		else (case  when ifnull(history.withdraw,0) > 0 then ifnull(history.fund - history.withdraw,0) 
                                    												 else (case when ifnull(history.deposit,0) > 0 then (history.fund + history.deposit) 
                                    												 				else ifnull(history.fund,0) end) end)
                                    end as fund,

                                    -- درصد از سبد 
                                    -- (case when pdb.trade_nav = 0 then 0 else ifnull(history.percent_of_basket,ifnull(history.fund,ac.price) / pdb.trade_nav) * 100 end) as before_percent_of_basket,
                                    -- ifnull(history.percent_of_basket,0) as before_percent_of_basket,
                                    -- مبلغ فعلی
                                    -- round((case when pdb.trade_nav = 0 then 0 else ifnull(history.percent_of_basket,ifnull(history.fund,ac.price) / pdb.trade_nav) end) * pdb.trade_nav,0) as current_fund
                                    case 	when ac.user_id = 0 then 
                                    			  (case when history.final_price is null then ac.price else ifnull(history.final_price,0) - ifnull(history.total_deposit,0) + ifnull(history.total_withdraw,0) end)
                                    		else (case when history.final_price = 0 then 
                                    							 (case 	when ac.user_id = 0 then (case  	when ifnull(history.withdraw,0) > 0 then ifnull(history.fund - history.withdraw,ac.price) 
                                    												 									else (case 	when ifnull(history.deposit,0) > 0 then (history.fund + history.deposit) 
                                    												 													else ifnull(history.fund,ac.price) 
                                    																							end) 
                                    																			end) - ifnull(total_deposit,0) + ifnull(total_withdraw,0)
                                    										else (case  when ifnull(history.withdraw,0) > 0 then ifnull(history.fund - history.withdraw,0) 
                                    												 		else (case 	when ifnull(history.deposit,0) > 0 then (history.fund + history.deposit) 
                                    												 						else ifnull(history.fund,0) 
                                    																end) 
                                    												end) 
                                    								end)
                                    						else (case 	when ifnull(history.withdraw,0) > 0 then ifnull(history.final_price,0) - ifnull(history.withdraw,0)
                                    										else (case 	when ifnull(history.deposit,0) > 0 then ifnull(history.final_price,0) + ifnull(history.deposit,0) 
                                    														else ifnull(history.final_price,0) 
                                    												end)
                                    								end)
                                    				end)
                                    end as current_fund
                                    from 
                                    -- ************************واریز و برداشت کاربران تا روز قبل
                                    (select ifnull(ac.user_id,0) as user_id,ifnull(u.name,'Separesh') as name,max(p.title) as portfolio,
                                    max(ac.portfolio_management_id) as portfolio_management_id,
                                    sum(ac.price) as price from user_accounts ac
                                    left join portfolio_managements p on p.id = ac.portfolio_management_id
                                    left join users u on u.id = ac.user_id
                                    where cast(ac.transaction_date as date) <= '$current_date' and 
                                    ac.payment_type in (3,4) and 
                                    ac.portfolio_management_id = $portfolio_management_id
                                    group by ac.user_id,u.name) ac 
                                    -- ************************ NAV روز قبل
                                    left join 
                                    (select t.portfolio_management_id,t.trade_nav,t.trade_percent,
                                    t.trade_date from portfolio_daily_trade t
                                    where t.trade_date <= '$before_date' and t.portfolio_management_id = $portfolio_management_id 
                                    order by t.trade_date desc
                                    LIMIT 1) pdb on pdb.portfolio_management_id = ac.portfolio_management_id
                                    -- ************************ تاریخچه روزقبل
                                    left join 
                                    (select h.*,ifnull(tot.total_deposit,0) as total_deposit,ifnull(tot.total_withdraw,0) as total_withdraw from user_finance_history h
                                    left join (select portfolio_management_id as pm_id,sum(case when user_id != 0 then deposit else 0 end) as total_deposit,
                                    						sum(case when user_id != 0 then withdraw else 0 end) as total_withdraw from user_finance_history
                                     				where trade_date = (select trade_date from user_finance_history where trade_date <= '$before_date' order by trade_date desc limit 1) and
                                     						user_id != 0
                                     				group by portfolio_management_id) tot on tot.pm_id = h.portfolio_management_id
                                    where h.trade_date = (select trade_date from user_finance_history where trade_date <= '$before_date' order by trade_date desc limit 1) and 
                                    h.portfolio_management_id = $portfolio_management_id
                                    order by h.trade_date desc
                                    ) history on history.portfolio_management_id = ac.portfolio_management_id and ifnull(history.user_id,0) = ac.user_id ) total 

                                    left join
                                    -- ************************واریز و برداشت کاربران امروز
                                    (select ac.user_id,u.name,
                                    sum(case when ac.payment_type = 3 then -ac.price else 0 end) as withdraw,
                                    sum(case when ac.payment_type = 4 then ac.price else 0 end) as deposit from user_accounts ac
                                    left join users u on u.id = ac.user_id
                                    where cast(ac.transaction_date as date) = '$current_date' and 
                                    ac.payment_type in (3,4) and 
                                    ac.portfolio_management_id = $portfolio_management_id
                                    group by ac.user_id,u.name) ac on ac.user_id = total.user_id
                                    order by user_id"));
    }

    public function scopeFinanceHistoryByPortfolioOld($query, $portfolio_management_id, $date)
    {
        $current_date = $date->toDateTimeString();
        $before_date = $date->subDay()->toDateTimeString();
        return DB::select(DB::raw("select total.user_id,total.name,total.portfolio_management_id,total.portfolio,total.trade_nav,total.fund,
                        total.before_percent_of_basket,total.current_fund,
                        -- سود و زیان
                        (total.current_fund - total.fund) as cost_benefit,
                        -- کارمزد سبد گردان
                        (case when total.current_fund - total.fund > 0 then round((total.current_fund - total.fund) * 0.2,0) else 0 end) as basket_commission,
                        -- مانده پس از کسر کارمزد
                        total.current_fund - 
                        (case when total.current_fund - total.fund > 0 then round((total.current_fund - total.fund) * 0.2,0) else 0 end) as remain_after_commission,
                        -- واریز وجه 
                        ifnull(ac.deposit,0) as deposit,
                        -- برداشت وجه
                        ifnull(ac.withdraw,0) as withdraw,
                        -- قابل برداشت
                        round(ifnull(ac.deposit,0) * 0.995 - ifnull(ac.withdraw,0) * 1.01 + 
                        total.current_fund - 
                        (case when total.current_fund - total.fund > 0 then round((total.current_fund - total.fund) * 0.2,0) else 0 end),0) as withdrawable,
                        -- مبلغ نهایی
                        case when ifnull(ac.withdraw,0) > 0 then 
                        	round(ifnull(ac.deposit,0) * 0.995 - ifnull(ac.withdraw,0) * 1.01 + 
                        	total.current_fund - 
                        	(case when total.current_fund - total.fund > 0 then round((total.current_fund - total.fund) * 0.2,0) else 0 end),0)
                        else 
                        	case when ifnull(ac.deposit,0) > 0 then ifnull(ac.deposit,0) + total.current_fund else total.current_fund end
                        end as final_price
                        from 
                        (select ac.user_id,ac.name,ac.portfolio_management_id,ac.portfolio,pdb.trade_nav,
                        -- سرمایه
                        case  when ifnull(history.withdraw,0) > 0 then ifnull(history.final_price,ac.price) 
                        else 
                        		case when ifnull(history.deposit,0) > 0 then history.fund + history.deposit 
                        		else ifnull(history.fund,ac.price) end 
                        end as fund,
                        -- درصد از سبد 
                        (case when pdb.trade_nav = 0 then 0 else ifnull(history.percent_of_basket,ifnull(history.fund,ac.price) / pdb.trade_nav) * 100 end) as before_percent_of_basket,
                        -- مبلغ فعلی
                        round((case when pdb.trade_nav = 0 then 0 else ifnull(history.percent_of_basket,ifnull(history.fund,ac.price) / pdb.trade_nav) end) * pdb.trade_nav,0) as current_fund
                        from 
                        -- ************************واریز و برداشت کاربران تا روز قبل
                        (select ac.user_id,u.name,max(p.title) as portfolio,
                        max(ac.portfolio_management_id) as portfolio_management_id,
                        sum(ac.price) as price from user_accounts ac
                        left join portfolio_managements p on p.id = ac.portfolio_management_id
                        left join users u on u.id = ac.user_id
                        where ac.transaction_date <= '$before_date' and 
                        ac.payment_type in (3,4) and 
                        ac.portfolio_management_id = '$portfolio_management_id'
                        group by ac.user_id,u.name) ac 
                        -- ************************ NAV روز قبل
                        left join 
                        (select t.portfolio_management_id,t.trade_nav,t.trade_percent,
                        t.trade_date from portfolio_daily_trade t
                        where t.trade_date <= '$before_date' and t.portfolio_management_id = '$portfolio_management_id' 
                        order by t.trade_date desc
                        LIMIT 1) pdb on pdb.portfolio_management_id = ac.portfolio_management_id
                        -- ************************ تاریخچه روزقبل
                        left join 
                        (select * from user_finance_history h
                        where h.trade_date = (select trade_date from user_finance_history 
                                                where trade_date <= '$before_date' order by trade_date desc limit 1) 
                        and h.portfolio_management_id = $portfolio_management_id
                        order by h.trade_date desc) history on history.portfolio_management_id = ac.portfolio_management_id and history.user_id = ac.user_id ) total 
                            
                        left join
                        -- ************************واریز و برداشت کاربران امروز
                        (select ac.user_id,u.name,
                        sum(case when ac.payment_type = 3 then ac.price else 0 end) as withdraw,
                        sum(case when ac.payment_type = 4 then ac.price else 0 end) as deposit from user_accounts ac
                        left join users u on u.id = ac.user_id
                        where ac.transaction_date = '$current_date' and 
                        ac.payment_type in (3,4) and 
                        ac.portfolio_management_id = '$portfolio_management_id'
                        group by ac.user_id,u.name) ac on ac.user_id = total.user_id"));
    }
}
