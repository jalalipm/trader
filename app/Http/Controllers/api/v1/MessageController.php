<?php

namespace App\Http\Controllers\api\v1;

use App\Helpers\MessageHelper;
use App\Http\Controllers\Controller;
use App\Model\Message;
use Illuminate\Http\Request;

class MessageController extends Controller
{


    public function show($id)
    {
        $item = Message::where('id', $id)->first();
        $data = ['message' => $item];
        return MessageHelper::instance()->sendResponse('Successfully received', $data, 200);
    }

    public function get_by_user(Message $message)
    {
        $list = Message::where('user_id', Auth()->user()->id)->orWhereNull('user_id')->get();
        $data = ['messages' => $list];
        return MessageHelper::instance()->sendResponse('Successfully received', $data, 200);
    }
}
