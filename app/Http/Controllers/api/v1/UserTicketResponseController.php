<?php

namespace App\Http\Controllers\api\v1;

use App\Helpers\MessageHelper;
use App\Http\Controllers\Controller;
use App\Model\UserTicketResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserTicketResponseController extends Controller
{

    public function get_by_ticket_id($id)
    {
        $item = UserTicketResponse::where('user_ticket_id', $id)->get();
        $data = ['user_ticket_responses' => $item];
        return MessageHelper::instance()->sendResponse('Successfully Recieved', $data, 200);
    }

    public function store(Request $request)
    {
        $data = [
            'user_id' => Auth::user()->id,
            'user_ticket_id' => $request->user_ticket_id,
            'response' => $request->response,
        ];
        $item = UserTicketResponse::create($data);
        $data = ['user_ticket_response' => $item];
        return MessageHelper::instance()->sendResponse('Successfully Inserted', $data, 201);
    }
}
