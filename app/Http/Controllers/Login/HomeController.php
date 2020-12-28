<?php

namespace App\Http\Controllers\Login;

use App\Model\OrderHeaderModel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index()
    {
//        dd(123);
        if (Auth::check()) {
            //$openOrders = OrderHeaderModel::whereIn('order_status',[1,3])->count();
            return view('layouts.index');
        } else {
            return view('auth.login');
        }
        //return view('frontend.user.login');
        //return view('frontend.home.mainIndex');
    }

    public function te()
    {
        dd(__DIR__);
    }
}
