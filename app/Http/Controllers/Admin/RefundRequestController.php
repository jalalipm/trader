<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\DateUtility;
use App\Http\Controllers\Controller;
use App\Model\PortfolioManagement;
use App\Model\RefundRequest;
use App\Model\UserFinanceHistory;
use Illuminate\Http\Request;

class RefundRequestController extends Controller
{
    public function index()
    {
        return view('admin.refund_requests.index');
    }

    public function anyData()
    {
        return datatables()->of(RefundRequest::RefundRequest()->get())
            ->addColumn('action', function ($refund_request) {
                return view('admin.refund_requests.operations', compact('refund_request'));
            })->make(true);
    }

    public function create()
    {
        $statuses = RefundRequest::STATUS_LIST;
        $portfolio_managements = PortfolioManagement::pluck('title', 'id');
        return view('admin.refund_requests.form-modal', compact('statuses', 'portfolio_managements'));
    }

    public function store(Request $request)
    {
        $refund_request_data = [
            'portfolio_management_id' => request()->input('portfolio_management_id'),
            'price' => request()->input('price'),
            'status' => request()->input('status'),
            'comment' => request()->input('comment'),
        ];
        $new_refund_request = RefundRequest::create($refund_request_data);
        if ($new_refund_request instanceof RefundRequest) {
            return response('new', 200);
        }
        return response(false, 400);
    }

    public function edit($id)
    {
        if ($id && ctype_digit($id)) {
            $refund_request = RefundRequest::find($id);
            // $statuses = [
            //     1 => 'در حال بررسی',
            //     2 => 'انصراف',
            //     3 => 'در حال انجام',
            //     4 => 'انجام شده',
            // ];
            $statuses = RefundRequest::STATUS_LIST;
            $portfolio_managements = PortfolioManagement::pluck('title', 'id');
            if ($refund_request && $refund_request instanceof RefundRequest) {
                return view('admin.refund_requests.form-modal', compact('refund_request', 'statuses', 'portfolio_managements'));
            }
        }
    }

    public function update(Request $request)
    {
        $refund_request_item = RefundRequest::find($request->id);
        $gDate = DateUtility::convertDigit_persian_english($request->shamsi_transaction_date);
        $transaction_date = DateUtility::shamsiTomiladi($gDate);
        $user_finance_history = UserFinanceHistory::where('trade_date', '<=', $transaction_date)
            ->where('portfolio_management_id', $request->portfolio_management_id)
            ->where('user_id', $request->user_id)->orderBy('trade_date', 'DESC')->first();
        $withdrawable = 0;
        if (isset($user_finance_history)) {
            $withdrawable = $user_finance_history->deposit * 0.995 - $user_finance_history->withdraw * 1.01 +
                ($user_finance_history->current_fund -
                    ($user_finance_history->current_fund - $user_finance_history->fund > 0 ?
                        round($user_finance_history->current_fund - $user_finance_history->fund * 0.2, 0) : 0));
        }

        if (!isset($user_finance_history)) {
            return response('refund_not_fund', 400);
        }

        if ($withdrawable < 0) {
            return response('refund_overflow', 400);
        }

        $input = request()->except('_token');
        $input['transaction_date'] = $transaction_date;
        $refund_request_item->update($input);
        return response('edit', 200);
    }

    public function destroy($id)
    {
        if ($id && ctype_digit($id)) {
            $refund_request = RefundRequest::find($id);
            if ($refund_request && $refund_request instanceof RefundRequest) {
                $refund_request->delete();
                return response('delete', 200);
            }
        }
    }
}
