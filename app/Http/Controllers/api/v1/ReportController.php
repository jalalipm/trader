<?php

namespace App\Http\Controllers\api\v1;

use App\Helpers\MessageHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\StockDataRequest;
use App\Model\PortfolioManagement;
use App\Model\StockData;
use App\Model\UserFinanceHistory;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    // public function cost_benefit_by_portfolio_report(Request $request)
    // {
    //     $user_id = Auth()->user()->id;
    //     $portfolio_management_id = $request->json()->get('portfolio_management_id');
    //     $start_date = $request->json()->get('start_date');
    //     $end_date = $request->json()->get('end_date');

    //     $data = UserFinanceHistory::CostBenefitReport()
    //         ->where('user_id', $user_id)
    //         ->where('portfolio_management_id', $portfolio_management_id)
    //         ->whereRaw("trade_date >= '$start_date' and trade_date <= '$end_date'")
    //         ->get();
    //     $data = [
    //         'cost_benefit_by_portfolio_report' => $data
    //     ];
    //     return MessageHelper::instance()->sendResponse('Successfully received', $data, 200);
    // }

    public function cost_benefit_report(Request $request)
    {
        $user_id = Auth()->user()->id;
        $portfolio_management_id = $request->json()->get('portfolio_management_id');
        $start_date = $request->json()->get('start_date');
        $end_date = $request->json()->get('end_date');

        $data = UserFinanceHistory::CostBenefitReport()
            ->where('user_id', $user_id)
            ->where('portfolio_management_id', $portfolio_management_id)
            ->whereRaw("trade_date >= '$start_date' and trade_date <= '$end_date'")
            ->get();
        $data = [
            'cost_benefit_report' => $data
        ];
        return MessageHelper::instance()->sendResponse('Successfully received', $data, 200);
    }
}
