<?php

namespace App\Http\Controllers\api\v1;

use App\Helpers\MessageHelper;
use App\Http\Controllers\Controller;
use App\Model\DraftOrder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DraftOrderController extends Controller
{

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
