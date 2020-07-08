<?php


namespace App\Helpers;


class MessageHelper
{
    public function sendResponse($message,$result,  $code = 200)
    {
        $response = [
            'success' => true,
            'data'    => $result,
            'message' => $message,
        ];
        return response()->json($response, $code);
    }

    public function sendError($error, $errorMessages = [], $code = 404)
    {
        $response = [
            'success' => false,
            'message' => $error,
        ];

        if(!empty($errorMessages)){
            $response['data'] = $errorMessages;
        }
        return response()->json($response, $code);
    }

//    public function startQueryLog()
//    {
//        \DB::enableQueryLog();
//    }
//
//    public function showQueries()
//    {
//        dd(\DB::getQueryLog());
//    }

    public static function instance()
    {
        return new MessageHelper();
    }
}
