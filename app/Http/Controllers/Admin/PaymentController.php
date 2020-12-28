<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Model\Payment;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function index()
    {
        return view('admin.payments.index');
    }

    public function anyData()
    {
        $user_accounts = Payment::Payment()->get();
        return datatables()->of($user_accounts)->make(true);
    }
}
