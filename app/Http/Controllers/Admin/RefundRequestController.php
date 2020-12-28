<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Model\PortfolioManagement;
use App\Model\RefundRequest;
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
        $statuses = [
            1 => 'در حال بررسی',
            2 => 'انصراف',
            3 => 'در حال انجام',
            4 => 'انجام شده',
        ];
        $portfolio_managements = PortfolioManagement::pluck('title', 'id');
        return view('admin.refund_requests.form-modal', compact('statuses', 'portfolio_managements'));
    }

    public function store(Request $request)
    {
        $refund_request_data = [
            // 'user_id' => request()->input('user_id'),
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
            $statuses = [
                1 => 'در حال بررسی',
                2 => 'انصراف',
                3 => 'در حال انجام',
                4 => 'انجام شده',
            ];
            $portfolio_managements = PortfolioManagement::pluck('title', 'id');
            if ($refund_request && $refund_request instanceof RefundRequest) {
                return view('admin.refund_requests.form-modal', compact('refund_request', 'statuses', 'portfolio_managements'));
            }
        }
    }

    public function update(Request $request)
    {
        $refund_request_item = RefundRequest::find($request->id);
        $input = request()->except('_token');
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
