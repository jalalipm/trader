<?php

namespace App\Http\Controllers\api\v1;

use App\Helpers\MessageHelper;
use App\Http\Controllers\Controller;
use App\Model\UserAccount;
use Illuminate\Http\Request;

class CommonController extends Controller
{

    public function contest()
    {
        $data = [
            'config' => Config('setting')
        ];
        return MessageHelper::instance()->sendResponse('Successfully received', $data, 200);
    }
}
