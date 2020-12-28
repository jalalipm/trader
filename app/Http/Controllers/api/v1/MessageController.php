<?php

namespace App\Http\Controllers\api\v1;

use App\Helpers\MessageHelper;
use App\Http\Controllers\Controller;
use App\Model\Message;
use Doctrine\DBAL\Query\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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

    public function message_read(Request $request)
    {

        $message_id = $request->json()->get('message_id');
        try {
            $Message = Message::find($message_id);
            $Message->update(['is_read' => 1]);
            $data = ['message' => $Message];
            return MessageHelper::instance()->sendResponse('Successfully received', $data, 200);
        } catch (QueryException $ex) {
            $error = $ex->getMessage();
            return MessageHelper::instance()->sendError('Error While Updating Data.', $error, 400);
        }
    }
}
