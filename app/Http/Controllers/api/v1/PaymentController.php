<?php

namespace App\Http\Controllers\api\v1;

use App\Helpers\MessageHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\PaymentRequest;
use App\Model\Payment;
use Carbon\Carbon;
use Illuminate\Http\Request;
// use Illuminate\Support\Facades\Validator;

class PaymentController extends Controller
{

    public function index()
    {
        $list = Payment::get();
        return MessageHelper::instance()->sendResponse('Successfully received', $list, 200);
    }

    public function store(Request $request)
    {
        // $validator = $this->validate::make($request->all(), [
        //     'name' => 'required|max:255',
        //     'email' => 'email|unique:users|max:50',
        //     'password' => 'required|confirmed|string|min:6',
        //     'national_code' => 'required|string|size:10',
        //     'first_name' => 'required|string|max:255',
        //     'last_name' => 'required|string|max:255',
        //     'address' => 'string|max:500',
        //     'cell_phone' => 'required|unique:users|string|size:11'
        // ]);

        // if ($validator->fails()) {
        //     return MessageHelper::instance()->sendError('Validation Error.', $validator->errors(), 422);
        // }
        // dd($request->modifiedAt);
        $data = [
            'ref_id' => $request->id,
            'amount' => $request->amount,
            'currency' => $request->currency,
            'reference_number' => $request->referenceNumber,
            'callback_url' => $request->callbackUrl,
            'description' => $request->description,
            'status' => $request->status,
            'init_payer_ip' => $request->initPayerIp,
            'redirect_payer_ip' => $request->redirectPayerIp,
            'transaction_date' => (new Carbon($request->modifiedAt)),
            'payer_card' => $request->payerCard,
            'payer_name' => $request->payerName,
            'payment_kind' => $request->amount > 0 ? 2 : 1,
            'is_success' => $request->status == 'SUCCESS' ? 1 : 0,
            'user_id' => $request->user_id,
        ];

        $payment = Payment::create($data);

        return MessageHelper::instance()->sendResponse('Successfully registered', $payment, 201);
    }

    public function show(Payment $payment)
    {
        //
    }

    public function update(Request $request, Payment $payment)
    {
        //
    }

    public function destroy(Payment $payment)
    {
        //
    }
}
