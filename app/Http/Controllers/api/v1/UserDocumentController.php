<?php

namespace App\Http\Controllers\api\v1;

use App\Helpers\MessageHelper;
use App\Http\Controllers\Controller;
use App\Model\UserDocument;
use App\User;
use Carbon\Carbon;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\URL;

class UserDocumentController extends Controller
{
    public function get_by_user()
    {
        $item = UserDocument::where('user_id', Auth::user()->id)->get();
        $data = ['user_documents' => $item];
        return MessageHelper::instance()->sendResponse('Successfully received', $data, 200);
    }

    public function store(Request $request)
    {

        $user_id = Auth()->user()->id;
        $data = [
            'user_id' => $user_id,
            'kind' =>  $request->kind,
            'status' =>  1
        ];
        if (Request()->hasFile('pic_path')) {
            $user = User::find($user_id);
            $timestamp = Carbon::now(new \DateTimeZone('Asia/Tehran'))->timestamp;
            $new_name = $user->name . '_' . $timestamp  . request()->file('pic_path')->getClientOriginalName();
            $file_path = request()->file('pic_path')->move(public_path('files/user_documents'), $new_name);
            if ($file_path instanceof \Symfony\Component\HttpFoundation\File\File) {
                $data['pic_path'] = url("/files/user_documents/{$new_name}");
            }
        }
        $user_doucument = UserDocument::create($data);
        $data = ['user_document' => UserDocument::find($user_doucument->id)];
        if ($user_doucument instanceof UserDocument) {
            return MessageHelper::instance()->sendResponse('Successfully Inserted', $data, 201);
        }
    }

    public function destroy($id)
    {
        try {
            $user_document = UserDocument::find($id);
            $base_url = URL::to('/');
            $file_name = public_path() . substr($user_document->pic_path, strlen($base_url));
            if (file_exists($file_name))
                try {
                    unlink($file_name);
                } catch (\Exception $e) {
                }
            $user_document->delete();
            $user = User::find(Auth()->user()->id);
            if ($user->UserDocuments()->count() == 0)
                $user->update(['status' => 1]);
            else
                $user->update(['status' => 2]);

            $data = ['user' => $user = User::find(Auth()->user()->id)];
            return MessageHelper::instance()->sendResponse('Successfully Deleted', $data, 200);
        } catch (QueryException $ex) {
            $string = $ex->getMessage();
            $error = ['errors' => $string];
            return MessageHelper::instance()->sendResponse('error while deleting data', $error, 400);
        }
    }
}
