<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Model\DraftOrder;
use Illuminate\Http\Request;

class DraftOrderController extends Controller
{
    public function anyData($user_id)
    {
        $draft_orders = DraftOrder::DraftOrder()->where('draft_orders.user_id', $user_id)->get();
        return datatables()->of($draft_orders)
            /*->addColumn('action', function ($draft_order) {
                return view('admin.users.partial.draft-order.operations', compact('draft_order'));
            })*/
            ->make(true);
    }

    public function send_to_order(Request $request)
    {
        dd($request->all());
    }
}
