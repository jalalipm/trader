<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\DateUtility;
use App\Http\Controllers\Controller;
use App\Model\PortfolioDailyTrade;
use App\Model\UserFinanceHistory;
use Carbon\Carbon;
use Illuminate\Http\Request;
use League\Fractal\Resource\Item;

class PortfolioDailyTradeController extends Controller
{
    public function index()
    {
        return view('admin.portfolio_daily_trades.index');
    }

    public function anyData($portfolio_management_id)
    {
        $portfolio_daily_trades = PortfolioDailyTrade::DailyTradeByPortfolioID($portfolio_management_id)->get();
        return datatables()->of($portfolio_daily_trades)
            ->addColumn('action', function ($portfolio_daily_trade) {
                return view('admin.portfolio_managements.daily_trade.operations', compact('portfolio_daily_trade'));
            })->make(true);
    }

    public function create($portfolio_management_id)
    {
        return view('admin.portfolio_managements.daily_trade.form-modal', compact('portfolio_management_id'));
    }

    public function store(Request $request)
    {
        $gDate = DateUtility::convertDigit_persian_english($request->shamsi_trade_date);
        $portfolio_daily_trade_data = [
            'portfolio_management_id' => request()->input('portfolio_management_id'),
            'trade_date' => DateUtility::shamsiTomiladi($gDate),
            'trade_percent' => request()->input('trade_percent'),
            'trade_nav' => request()->input('trade_nav'),
        ];
        $new_portfolio_daily_trades = PortfolioDailyTrade::create($portfolio_daily_trade_data);
        $date = DateUtility::shamsiTomiladi($gDate);
        $portfolio_count = PortfolioDailyTrade::where('portfolio_management_id', $new_portfolio_daily_trades->portfolio_management_id)->count();
        if ($new_portfolio_daily_trades instanceof PortfolioDailyTrade) {
            if ($portfolio_count > 1) {
                $this->finance_history_calc(request()->input('portfolio_management_id'), $date, request()->input('trade_percent'));
            }
            return response('create', 200);
        }
        return response(false, 400);
    }

    public function finance_history_calc($portfolio_management_id, $date, $trade_percent)
    {
        $befor_date = $date;

        // dd($l, $portfolio_management_id, $date->subDay()->format('Y-m-d'));
        // dd($date->format('Y-m-d'));
        UserFinanceHistory::where('trade_date', $date->subDay()->format('Y-m-d'))
            ->where('portfolio_management_id', $portfolio_management_id)
            ->delete();
        // dd($l, $date->addDay()->format('Y-m-d'), $date->format('Y-m-d'));
        $result =  UserFinanceHistory::FinanceHistoryByPortfolio($portfolio_management_id, $date->addDay());
        $result = json_decode(json_encode($result), true);
        $user_finance_history = [];
        $total_final_price = 0;
        foreach ($result as $item) {
            $total_final_price = $total_final_price  + $item['current_fund'];
        }
        // dd($result[0], $portfolio_management_id, $date);
        foreach ($result as $item) {
            $input = [
                'user_id' => ($item['user_id'] == 0 ? null : $item['user_id']),
                'portfolio_management_id' => $portfolio_management_id,
                'trade_date' =>  $date->toDateTimeString(),
                'fund' => round($item['fund'], 0),
                // 'before_percent_of_basket' => $item['before_percent_of_basket'],
                'current_fund' =>  round($item['current_fund'], 0),
                'deposit' =>  round($item['deposit'], 0),
                'withdraw' =>  round($item['withdraw'], 0),
                'pure_price' =>  round($item['current_fund'], 0),
                'percent_of_basket' =>  round($item['current_fund'], 0) /  $total_final_price,
                'final_price' =>  round($item['current_fund'], 0) + (round($item['current_fund'] * $trade_percent / 100, 0)),
            ];
            array_push($user_finance_history, $input);
        }
        // dd($date->format('Y-m-d'));

        // dd($l, $date->format('Y-m-d'));
        // dd($user_finance_history[0], $user_finance_history[1]);
        UserFinanceHistory::insert($user_finance_history);
    }

    public function edit($id)
    {
        if ($id && ctype_digit($id)) {
            $portfolio_daily_trade = PortfolioDailyTrade::find($id);
            $portfolio_management_id = $portfolio_daily_trade->portfolio_management_id;
            if ($portfolio_daily_trade && $portfolio_daily_trade instanceof PortfolioDailyTrade) {
                return view(
                    'admin.portfolio_managements.daily_trade.form-modal',
                    compact('portfolio_daily_trade', 'portfolio_management_id')
                );
            }
        }
    }

    public function update(Request $request)
    {
        $portfolio_daily_trades_item = PortfolioDailyTrade::find($request->id);
        $input = request()->except('_token');
        $input['trade_date'] = DateUtility::shamsiTomiladi($request->shamsi_trade_date);
        $portfolio_daily_trades_item->update($input);
        $portfolio_count = PortfolioDailyTrade::where('portfolio_management_id', $portfolio_daily_trades_item->portfolio_management_id)->count();
        if ($portfolio_count > 1) {
            $this->finance_history_calc(request()->input('portfolio_management_id'), $input['trade_date'], $request->trade_percent);
        }
        return response('update', 200);
    }

    public function destroy($id)
    {
        if ($id && ctype_digit($id)) {
            $portfolio_daily_trades = PortfolioDailyTrade::find($id);
            if ($portfolio_daily_trades && $portfolio_daily_trades instanceof PortfolioDailyTrade) {
                $portfolio_daily_trades->delete();
                $trade_date = Carbon::parse($portfolio_daily_trades->trade_date)->subDay()->format('Y-m-d');
                UserFinanceHistory::where('trade_date', $trade_date)
                    ->where('portfolio_management_id', $portfolio_daily_trades->portfolio_management_id)
                    ->delete();
            }
        }
    }
}
