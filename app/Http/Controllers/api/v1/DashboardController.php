<?php

namespace App\Http\Controllers\api\v1;

use App\Helpers\MessageHelper;
use App\Http\Controllers\Controller;
use App\Model\PortfolioManagement;
use App\Model\UserAccount;
use App\Model\UserFinanceHistory;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use phpseclib\Crypt\Random;

class DashboardController extends Controller
{

    public function get_dashboard()
    {
        $x = [];
        $y = [];
        $cost_benefit_total_report = UserFinanceHistory::CostBenefitTotalReport()
            ->where('user_finance_history.user_id', Auth::user()->id);
        $cost_benefit_report = UserFinanceHistory::CostBenefitReport()
            ->where('user_finance_history.user_id', Auth::user()->id)
            ->groupBy('user_finance_history.user_id', 'user_finance_history.trade_date')
            ->select([
                'user_finance_history.user_id',
                'user_finance_history.trade_date',
                DB::raw("sum(user_finance_history.final_price) as final_price"),
            ]);
        foreach ($cost_benefit_report->get() as $item) {
            $x[] = Carbon::parse($item->trade_date)->timestamp * 1000;
            $y[] = $item->final_price * 1;
        }
        // $cost_benefit_total_report->sum('final_price');
        $portfolio_list = PortfolioManagement::orderBy('interest_rate', 'Desc')->take(5)->get();
        // $cost_benefit_total_report->orderBy('trade_date', 'desc')->get();
        $data = [
            'dashboard' => [
                'user_balance' => UserAccount::GetByUserID(Auth::user()->id)->sum('user_accounts.price'),
                'portfolio_managements' => $portfolio_list,
                'today_income' => $cost_benefit_total_report->sum('final_price') - $cost_benefit_total_report->sum('pure_price'),
                'today_income_percent' => $cost_benefit_total_report->sum('final_price')  == 0 ? 0 : ($cost_benefit_total_report->sum('final_price') - $cost_benefit_total_report->sum('pure_price')) * 100 / $cost_benefit_total_report->sum('final_price'),
                'income' => $cost_benefit_total_report->sum('final_price'),
                'income_percent' => $cost_benefit_total_report->sum('fund') == 0 ? 0 : $cost_benefit_total_report->sum('final_price') / $cost_benefit_total_report->sum('fund') * 100,
                'x' => $x,
                'y' => $y,
            ]
        ];

        return MessageHelper::instance()->sendResponse('Successfully received', $data, 200);
    }
}
