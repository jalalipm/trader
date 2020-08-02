<?php

namespace App\Http\Controllers\api\v1;

use App\Helpers\MessageHelper;
use App\Http\Controllers\Controller;
use App\Model\Faq;
use Illuminate\Http\Request;

class FaqController extends Controller
{

    public function index()
    {
        $list = Faq::get();
        $data = ['faqs' => $list];
        return MessageHelper::instance()->sendResponse('Successfully received', $data, 200);
    }
}
