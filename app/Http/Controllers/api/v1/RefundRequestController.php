<?php

namespace App\Http\Controllers\api\v1;

use App\Helpers\MessageHelper;
use App\Http\Controllers\Controller;
use App\Model\RefundRequest;
use App\Model\UserFinanceHistory;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RefundRequestController extends Controller
{
    public function index()
    {
        //
    }

    public function get_by_user()
    {
        $list = RefundRequest::GetByUser(Auth::user()->id)->get();
        $data = ['refund_requests' => $list];
        return MessageHelper::instance()->sendResponse('Successfully registered', $data, 200);
    }

    public function get_by_portfolio_management($portfolio_management_id)
    {
        $list = RefundRequest::where('portfolio_management_id', $portfolio_management_id)->get();
        $data = ['refund_requests' => $list];
        return MessageHelper::instance()->sendResponse('Successfully registered', $data, 200);
    }

    public function store(Request $request)
    {
        $Date = Carbon::now(new \DateTimeZone('Asia/Tehran'));
        $data = [
            'user_id' => Auth::user()->id,
            'portfolio_management_id' => $request->portfolio_management_id,
            'price' => $request->price,
            'status' => RefundRequest::PROCESSING,
            'request_date' => strval($Date),
            'comment' => $request->comment
        ];
        $item = RefundRequest::create($data);
        $item_new = RefundRequest::RefundRequest()->find($item->id);
        $data = ['refund_request' => $item_new];
        return MessageHelper::instance()->sendResponse('Successfully registered', $data, 201);
    }

    public function show($id)
    {
        $item = RefundRequest::RefundRequest()->find($id);
        $data = ['refund_request' => $item];
        return MessageHelper::instance()->sendResponse('Successfully registered', $data, 200);
    }

    public function update(Request $request)
    {
        // dd($request->all());
        $item = RefundRequest::find($request->id);
        if ($item->status != RefundRequest::PROCESSING) {
            $dataList = [
                'portfolio_management_id' => $request->portfolio_management_id,
                'price' => $request->price,
                'comment' => $request->comment
            ];
            $item->update($dataList);
            $item = RefundRequest::RefundRequest()->find($request->id);
            $data = ['refund_request' => $item];
            return MessageHelper::instance()->sendResponse('Successfully Updated', $data, 200);
        } else {
            return MessageHelper::instance()->sendResponse('Refund Status Not Valid', null, 400);
        }
    }

    public function destroy($id)
    {
        $item = RefundRequest::find($id);
        if ($item->status != RefundRequest::PROCESSING) {
            $item->delete();
            return MessageHelper::instance()->sendResponse('Successfully Deleted', null, 200);
        } else {
            return MessageHelper::instance()->sendResponse('Refund Status Not Valid', null, 400);
        }
    }
}
