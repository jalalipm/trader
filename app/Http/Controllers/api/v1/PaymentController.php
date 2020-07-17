<?php

namespace App\Http\Controllers\api\v1;

use App\Helpers\jibit_api\Jibit;
use App\Helpers\MessageHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\PaymentRequest;
use App\Model\DraftOrder;
use App\Model\Payment;
use App\Model\UserAccount;
use Carbon\Carbon;
use Dotenv\Result\Result;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

// use Illuminate\Support\Facades\Validator;

class PaymentController extends Controller
{

    public function index()
    {
        $list = Payment::get();
        return MessageHelper::instance()->sendResponse('Successfully received', $list, 200);
    }

    public function store(PaymentRequest $request)
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

    public function do_pay(Request $request)
    {
        $apiKey = config('jibit.username');
        $apiSecret = config('jibit.password');
        $jibit = new Jibit($apiKey, $apiSecret);
        $amount = $request->amount;
        $factorNumber = $request->json()->has('order_no') ? $request->json()->get('order_no') : 0;
        $mobile = $request->json()->has('cell_phone') ? $request->json()->get('cell_phone') : 0;
        $callback_url = $request->json()->get('callback_url');
        $order_arr = $request->json()->get('order');
        try {
            $requestResult = $jibit->paymentRequest($amount, $factorNumber, $mobile, $callback_url);
            $data = [
                'payment_url' => $requestResult['pspSwitchingUrl'],
                'tracking_code' => $requestResult['orderIdentifier']
            ];
            $proxy = new DraftOrderController();
            foreach ($order_arr as $item) {
                $data_arr[] = [
                    'user_id' => Auth::user()->id,
                    'portfolio_management_id' => $item['portfolio_management_id'],
                    'price' => $item['price'],
                    'tracking_code' => $requestResult['orderIdentifier']
                ];
            }
            $proxy->store($data_arr);
            return MessageHelper::instance()->sendResponse('Successfully Recived', $data, 200);
        } catch (\Exception $ex) {
            $string = $ex->getMessage();
            $data = ['errors' => $string];
            return MessageHelper::instance()->sendError('error while recived data', $data, 400);
        }
    }

    public function pay_verify(Request $request)
    {
        $ref_id = $request->json()->get('ref_id');
        $apiKey = config('jibit.username');
        $apiSecret = config('jibit.password');
        $jibit = new Jibit($apiKey, $apiSecret);
        try {
            $verify = $jibit->paymentVerify($ref_id);
            if ($verify['status'] == 'SUCCESS') {
                $data = [
                    "user_id" => Auth::user()->id,
                    "ref_id" => $verify['id'],
                    "amount" =>  $verify['amount'],
                    "currency" => !isset($verify['currency']) ? null : $verify['currency'],
                    "reference_number" => !isset($verify['referenceNumber']) ? null : $verify['referenceNumber'],
                    "callback_url" =>  !isset($verify['callbackUrl']) ? null : $verify['callbackUrl'],
                    "description" => isset($verify['description']) ? $verify['description'] : null,
                    "status" => !isset($verify['status']) ? null : $verify['status'],
                    "init_payer_ip" => !isset($verify['initPayerIp']) ? null : $verify['initPayerIp'],
                    "redirect_payer_ip" => !isset($verify['redirectPayerIp']) ? null : $verify['redirectPayerIp'],
                    "transaction_date" => !isset($verify['modifiedAt']) ? null : Carbon::parse($verify['modifiedAt']),
                    "payer_card" => !isset($verify['payerCard']) ? null : $verify['payerCard'],
                    "payer_name" => !isset($verify['payerName']) ? null : $verify['payerName'],
                    "payment_kind" => 2,
                    "is_success" => (!isset($verify['status']) ? null : $verify['status']) == 'SUCCESS' ? 1 : 0,
                ];
                Payment::create($data);
                $data = $this->user_account($ref_id, Carbon::parse($verify['modifiedAt']));
                // dd($data);
            }
            return MessageHelper::instance()->sendResponse('Successfully Recived', $verify, 200);
        } catch (\Exception $ex) {
            $string = $ex->getMessage();
            return response()->json(['code' => '1004', 'message' => 'error while inserting data', 'errors' => $string], 400);
        }
    }

    private function user_account($ref_id, $transaction_date)
    {
        $draft_order = DraftOrder::where('tracking_code', $ref_id)->get();
        foreach ($draft_order as $item) {
            $data_arr[] = [
                'user_id' => $item['user_id'],
                'portfolio_management_id' => $item['portfolio_management_id'],
                'price' => $item['price'],
                'tracking_code' => $item['tracking_code'],
                'payment_kind' => 2,
                'payment_type' => 4,
                'transaction_date' => $transaction_date
            ];
        }
        $proxy = new UserAccountController();
        $result =  $proxy->store($data_arr);
        return $result;
    }
}
