<?php

namespace App\Http\Controllers\api\v1;

use App\Helpers\MessageHelper;
use App\Http\Controllers\Controller;
use App\Model\UserTicket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserTicketController extends Controller
{
    public function index()
    {
        //
    }

    public function get_by_user()
    {
        $item = UserTicket::where('user_id', Auth::user()->id)->with('UserTicketResponses')->get();
        $data = ['user_tickets' => $item];
        return MessageHelper::instance()->sendResponse('Successfully Recieved', $data, 200);
    }

    public function store(Request $request)
    {
        $data = [
            'user_id' => Auth::user()->id,
            'title' => $request->title,
            'comment' => $request->comment,
            'full_name' => $request->full_name,
            'cell_phone' => $request->cell_phone,
        ];
        $item = UserTicket::create($data);
        $data = ['user_ticket' => $item];
        return MessageHelper::instance()->sendResponse('Successfully Inserted', $data, 201);
    }

    public function show($id)
    {
        $item = UserTicket::with('UserTicketResponses')->find($id);
        $data = ['user_ticket' => $item];
        return MessageHelper::instance()->sendResponse('Successfully Recieved', $data, 200);
    }

    public function update(Request $request, UserTicket $userTickt)
    {
        //
    }

    public function destroy(UserTicket $userTickt)
    {
        //
    }
}
