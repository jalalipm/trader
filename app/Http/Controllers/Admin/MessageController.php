<?php

namespace App\Http\Controllers\Admin;

use App\Events\SendNotification;
use App\Http\Controllers\Controller;
use App\Model\Message;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MessageController extends Controller
{
    public function index()
    {
        return view('admin.messages.index');
    }

    public function anyData()
    {
        $message_list = Message::Message();
        return datatables()->of($message_list)
            ->addColumn('action', function ($message) {
                return view('admin.messages.operations', compact('message'));
            })->make(true);
    }

    public function create()
    {
        $customers = User::pluck('name', 'id')->all();
        return view('admin.messages.form-modal', compact('customers'));
    }

    public function store(Request $request)
    {
        $message_data = [
            'user_id' => request()->input('user_id'),
            'title' => request()->input('title'),
            'message' => request()->input('message'),
        ];
        $new_message = Message::create($message_data);
        $user = User::find($request->user_id);
        $data = [
            'imei' => $user->push_id,
            'title' => $request->title,
            'content' => $request->message,
            'item_id' => $new_message->id,
            'type' => 'message',
            'json_data' => ''
        ];
        // dd($data);
        event(new SendNotification($data));
        if ($new_message instanceof Message) {
            return response('create', 200);
        }
        return response(false, 400);
    }

    public function SendToAll(Request $request)
    {
        if (isset($request->message)) {
            $data = [
                'title' => $request->title,
                'content' => $request->message,
                'item_id' => -1,
                'type' => 'info',
                'json_data' => ''
            ];
            event(new SendNotification($data));
            return response('ok', 200);
        } else {
            return response(false, 400);
        }
    }

    public function edit($id)
    {
        $customers = User::pluck('name', 'id')->all();
        if ($id && ctype_digit($id)) {
            $message = Message::find($id);
            if ($message && $message instanceof Message) {
                return view('admin.messages.form-modal', compact('message', 'customers'));
            }
        }
    }

    public function update(Request $request)
    {
        $input = request()->except('_token');
        $message_item = Message::find($request->id);
        $message_item->update($input);
        return response('update', 200);
    }

    public function destroy($id)
    {
        if ($id && ctype_digit($id)) {
            $message = Message::find($id);
            if ($message && $message instanceof Message) {
                $message->delete();
                return redirect()->route('admin.messages.list');
            }
        }
    }
}
