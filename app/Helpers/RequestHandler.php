<?php


function PostRequests($SendData)
{
    // dd($SendData);
    if (isset($SendData['imei'])) { //FireBase
        $data = '{"to": "' . $SendData['imei'] . '",
            "notification": { "body" : "' . $SendData['content'] . '", "title" : "' . $SendData['title'] . '", "sound" : "default" },
            "data" : {"type" : "' . $SendData['type'] . '","item_id" : "' . $SendData['item_id'] . '",
            "json_data" : ' . (array_key_exists('json_data', $SendData) ? json_encode($SendData['json_data']) : '') . '}, 
            "android" : {"priority" : "high"} }';
        // dd($data);
        $response1 = \Ixudra\Curl\Facades\Curl::to(Config('setting.general.firebase_url'))
            ->withContentType('application/json; charset=utf-8')
            ->withHeaders(array(Config('setting.general.firebase_authorization')))
            ->withData($data)
            ->post();
    }
    if (!isset($SendData['imei'])) {
        //FireBase*/
        $data = '{"to": "/topics/' . Config('setting.general.firebase_topics_name') . '",
            "notification": { "body" : "' . $SendData['content'] . '", "title" : "' . $SendData['title'] . '", "sound" : "default" },
            "data" : {"type" : "' . $SendData['type'] . '","item_id" : "' . $SendData['item_id'] . '","json_data" : " "}, 
            "android" : {"priority" : "high"} }';
        $response_onesignal = \Ixudra\Curl\Facades\Curl::to(Config('setting.general.firebase_url'))
            ->withContentType('application/json; charset=utf-8')
            ->withHeaders(array(Config('setting.general.firebase_authorization')))
            ->withData($data)
            ->post();
    }
}
