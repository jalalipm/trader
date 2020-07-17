<?php

namespace App\Http\Controllers\api\v1;

use App\Helpers\MessageHelper;
use App\Http\Controllers\Controller;
use App\Model\DraftOrder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DraftOrderController extends Controller
{

    public function index()
    {
        //
    }

    public function store($request)
    {
        // dd($request, $user_id, $tracking_code);
        // $id = $user_id;
        // $code = $tracking_code;
        // foreach ($request as $item)  {
        //     // dd($user_id);
        //     $data = [
        //         'user_id' => $id,
        //         'portfolio_management_id' => $item['portfolio_management_id'],
        //         'price' => $item - ['price'],
        //         'tracking_code' => $code
        //     ];
        //     dd($data);
        //     // $data[] = ;
        // }
        DraftOrder::insert($request);
    }

    public function show(DraftOrder $draftOrders)
    {
        //
    }

    public function update(Request $request, DraftOrder $draftOrders)
    {
        //
    }

    public function destroy($id)
    {
        $item = DraftOrder::find($id);
        if ($item->status != 1) {
            $item->delete();
            return MessageHelper::instance()->sendResponse('Successfully Deleted', [], 200);
        } else {
            return MessageHelper::instance()->sendResponse('Refund Status Not Valid', null, 400);
        }
    }
}
