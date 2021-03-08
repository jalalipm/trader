<?php

namespace App\Http\Controllers\api\v1;

use App\Helpers\jibit_api\Jibit;
use App\Helpers\MessageHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\PaymentRequest;
use App\Model\DraftOrder;
use App\Model\Payment;
use App\Model\PortfolioDailyTrade;
use App\Model\UserAccount;
use App\Model\UserFinanceHistory;
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

    public function get_by_user()
    {
        $list = Payment::where('user_id', Auth()->user()->id)->get();
        $data = ['payments' => $list];
        return MessageHelper::instance()->sendResponse('Successfully received', $data, 200);
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
        $data = ['payment' => $payment];
        return MessageHelper::instance()->sendResponse('Successfully registered', $data, 201);
    }

    public function do_pay(Request $request)
    {
        $apiKey = config('jibit.username');
        $apiSecret = config('jibit.password');
        $jibit = new Jibit($apiKey, $apiSecret);
        $amount = $request->amount;
        $factorNumber = $request->order_no; //$request->json()->has('order_no') ? $request->json()->get('order_no') : 0;
        $mobile = $request->cell_phone; //$request->json()->has('cell_phone') ? $request->json()->get('cell_phone') : 0;
        $callback_url = 'https://trade.separesh.shop/app.html'; // $request->callback_url; // $request->json()->get('callback_url');
        $order_arr = $request->order; // $request->json()->get('order');
        // dd($order_arr);
        try {
            $requestResult = $jibit->paymentRequest($amount, $factorNumber, $mobile, $callback_url);
            $data = [
                'payment_url' => $requestResult['pspSwitchingUrl'],
                'tracking_code' => $requestResult['orderIdentifier']
            ];
            // dd($data);
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
        $ref_id = $request->ref_id;
        $apiKey = config('jibit.username');
        $apiSecret = config('jibit.password');
        $jibit = new Jibit($apiKey, $apiSecret);
        try {
            $verify = $jibit->paymentVerify($ref_id);

            if ($verify['status'] == 'Successful') {
                $inquiry = $jibit->paymentInquiry($ref_id);
                // $data = [
                //     "user_id" => Auth::user()->id,
                //     "ref_id" => $verify['id'],
                //     "amount" =>  $verify['amount'],
                //     "currency" => !isset($verify['currency']) ? null : $verify['currency'],
                //     "reference_number" => !isset($verify['referenceNumber']) ? null : $verify['referenceNumber'],
                //     "callback_url" =>  !isset($verify['callbackUrl']) ? null : $verify['callbackUrl'],
                //     "description" => isset($verify['description']) ? $verify['description'] : null,
                //     "status" => !isset($verify['status']) ? null : $verify['status'],
                //     "init_payer_ip" => !isset($verify['initPayerIp']) ? null : $verify['initPayerIp'],
                //     "redirect_payer_ip" => !isset($verify['redirectPayerIp']) ? null : $verify['redirectPayerIp'],
                //     "transaction_date" => !isset($verify['modifiedAt']) ? null : Carbon::parse($verify['modifiedAt']),
                //     "payer_card" => !isset($verify['payerCard']) ? null : $verify['payerCard'],
                //     "payer_name" => !isset($verify['payerName']) ? null : $verify['payerName'],
                //     "payment_kind" => 2,
                //     "is_success" => (!isset($verify['status']) ? null : $verify['status']) == 'SUCCESS' ? 1 : 0,
                // ];
                $data = [
                    "user_id" => Auth::user()->id,
                    "ref_id" => $inquiry['id'],
                    "amount" =>  $inquiry['amount'],
                    "currency" => !isset($inquiry['currency']) ? null : $inquiry['currency'],
                    "reference_number" => !isset($inquiry['referenceNumber']) ? null : $inquiry['referenceNumber'],
                    "callback_url" =>  !isset($inquiry['callbackUrl']) ? null : $inquiry['callbackUrl'],
                    "description" => isset($inquiry['description']) ? $inquiry['description'] : null,
                    "status" => !isset($inquiry['status']) ? null : $inquiry['status'],
                    // "status" => 'SUCCESS',
                    "init_payer_ip" => !isset($inquiry['initPayerIp']) ? null : $inquiry['initPayerIp'],
                    "redirect_payer_ip" => !isset($inquiry['redirectPayerIp']) ? null : $inquiry['redirectPayerIp'],
                    "transaction_date" => !isset($inquiry['modifiedAt']) ? null : Carbon::parse($inquiry['modifiedAt']),
                    "payer_card" => !isset($inquiry['payerCard']) ? null : $inquiry['payerCard'],
                    "payer_name" => !isset($inquiry['payerName']) ? null : $inquiry['payerName'],
                    "payment_kind" => 2,
                    "is_success" => (!isset($inquiry['status']) ? null : $inquiry['status']) == 'SUCCESS' ? 1 : 0,
                ];
                $payment =  Payment::create($data);
                $user_account = $this->user_account($ref_id, $payment->id, Carbon::parse($verify['modifiedAt']));
                $data = ['payment_result' => $verify];
                return MessageHelper::instance()->sendResponse('Successfully Recived', $data, 200);
            }
            return MessageHelper::instance()->sendResponse('Successfully Recived', ['status' => false], 200);
        } catch (\Exception $ex) {
            $string = $ex->getMessage();
            return response()->json(['code' => '1004', 'message' => 'error while inserting data', 'errors' => $string], 400);
        }
    }

    private function user_account($ref_id, $payment_id, $transaction_date)
    {
        $draft_order = DraftOrder::where('tracking_code', $ref_id)->get();
        foreach ($draft_order as $item) {
            $data_arr[] = [
                'payment_id' => $payment_id,
                'user_id' => $item['user_id'],
                'portfolio_management_id' => $item['portfolio_management_id'],
                'price' => $item['price'],
                'payment_kind' => UserAccount::DEBIT,
                'payment_type' => UserAccount::PAYMENT,
                'transaction_date' => $transaction_date
            ];
        }
        $proxy = new UserAccountController();
        $result =  $proxy->store($data_arr);
        $portfolio_daily_trade =  PortfolioDailyTrade::where('trade_date', $transaction_date)->first();
        $this->finance_history_calc(
            $item['portfolio_management_id'],
            $transaction_date,
            (isset($portfolio_daily_trade) ? 0 : $portfolio_daily_trade->trade_percent)
        );
        return $result;
    }

    public function finance_history_calc($portfolio_management_id, $date, $trade_percent)
    {
        $current_date = $date;
        UserFinanceHistory::where('trade_date', $current_date)
            ->where('portfolio_management_id', $portfolio_management_id)
            ->delete();
        $result =  UserFinanceHistory::FinanceHistoryByPortfolio($portfolio_management_id, $current_date);
        $current_date = $date->addDay();
        $result = json_decode(json_encode($result), true);
        $user_finance_history = [];
        $total_final_price = 0;
        foreach ($result as $item) {
            $total_final_price = $total_final_price + $item['current_fund'];
        }
        foreach ($result as $item) {
            $input = [
                'user_id' => ($item['user_id'] == 0 ? null : $item['user_id']),
                'portfolio_management_id' => $portfolio_management_id,
                'trade_date' =>  $current_date->format('Y-m-d'),
                'fund' => round($item['fund'], 0),
                'current_fund' =>  round($item['current_fund'], 0),
                'deposit' =>  round($item['deposit'], 0),
                'withdraw' =>  round($item['withdraw'], 0),
                'pure_price' =>  round($item['current_fund'], 0),
                'percent_of_basket' =>  round($item['current_fund'], 0) / $total_final_price,
                'final_price' =>  round($item['current_fund'], 0) + (round($item['current_fund'] * $trade_percent / 100, 0)),
            ];
            array_push($user_finance_history, $input);
        }
        UserFinanceHistory::insert($user_finance_history);
    }
}
