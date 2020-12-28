<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Model\UserTicket;
use App\Model\UserTicketResponse;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserTicketController extends Controller
{
    public function index()
    {
        return view('admin.user_tickets.index');
    }

    public function anyData()
    {
        return datatables()->eloquent(UserTicket::UserTicket())
            ->addColumn('action', function ($user_ticket) {
                return view('admin.user_tickets.operations', compact('user_ticket'));
            })->make(true);
    }

    public function edit($id)
    {
        if ($id && ctype_digit($id)) {
            $user_ticket = UserTicket::UserTicket()->find($id);
            $user_ticket_responses = UserTicketResponse::TicketResponse()->where('user_ticket_id', $id)->get();
            if ($user_ticket && $user_ticket instanceof UserTicket) {
                return view('admin.user_tickets.form-modal', compact('user_ticket', 'user_ticket_responses'));
            }
        }
    }

    public function store_user_response_ticket(Request $request)
    {
        $data = [
            'user_id' => Auth()->user()->id,
            'user_ticket_id' => request()->input('ticket_id'),
            'response' => request()->input('response'),
        ];
        $user_response_ticket = UserTicketResponse::create($data);
        // $user = User::find($request->customer_id);
        // if ($user->push_id != null) {
        //     $data = [
        //         'imei' => $user->push_id,
        //         'title' => $request->title,
        //         'content' => $request->message,
        //         'employer_id' => Auth::user()->employer_id,
        //         'item_id' => $user_response_ticket->id,
        //         'type' => 'user_response_ticket'
        //     ];
        //     event(new SendNotification($data));
        // }
        if ($user_response_ticket instanceof UserTicketResponse) {
            $result = UserTicketResponse::TicketResponse()->find($user_response_ticket->id);
            return response(['response' => $result], 200);
        }
        return response(false, 400);
    }
}
