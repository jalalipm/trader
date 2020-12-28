<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\AccessUser;
use App\Helpers\DateUtility;
use App\Http\Controllers\Controller;
use App\Model\PortfolioManagement;
use App\Model\UserFinanceHistory;
use App\User;
use Carbon\Carbon;
use Hekmatinasser\Verta\Verta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    public function index()
    {
        $user_list = User::pluck('name', 'id');
        $portfolio_management_list = PortfolioManagement::pluck('title', 'id');
        $report_title = 'گزارش سود و زیان کاربر بر اساس سبدگردان';
        return view('admin.reports.index', compact(
            'report_title',
            'portfolio_management_list',
            'user_list'
        ));
    }

    public function cost_benefit_report(Request $request)
    {
        $center_id = $request->center_id;
        $condition = $this->create_condition($request);
        return view('admin.reports.cost_benefit.report', compact('condition'));
    }

    public function cost_benefit_report_any_data($condition)
    {
        $condition = str_replace('@', '%', $condition);
        $data = UserFinanceHistory::CostBenefitReport()
            ->whereRaw("1=1 $condition")
            ->get();
        return datatables()->of($data)->make(true);
    }

    function create_condition($request)
    {
        $condition = "";
        if ($request->has('user_id') && $request->get('user_id') != null) {
            $condition = $condition . ' and user_id = ' . $request->get('user_id');
        }
        if ($request->has('portfolio_management_id') && $request->get('portfolio_management_id') != null) {
            $condition = $condition . ' and portfolio_management_id = ' . $request->get('portfolio_management_id');
        }
        //----------------------
        if ($request->has('start_date') && $request->get('start_date') != null) {
            $start_date = DateUtility::convertDigit_persian_english($request->start_date);
            $condition = $condition . " and cast(trade_date as date) >= '" . DateUtility::shamsiTomiladi($start_date)->toDateString() . "'";
        }
        if ($request->has('end_date') && $request->get('end_date') != null) {
            $end_date = DateUtility::convertDigit_persian_english($request->end_date);
            $condition = $condition . " and cast(trade_date as date) <= '" . DateUtility::shamsiTomiladi($end_date)->toDateString() . "'";
        }
        return $condition;
    }
}
