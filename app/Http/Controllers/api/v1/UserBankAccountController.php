<?php

namespace App\Http\Controllers\api\v1;

use App\Helpers\MessageHelper;
use App\Http\Controllers\Controller;
use App\Model\UserBankAccount;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserBankAccountController extends Controller
{
    public function index()
    {
        //
    }

    public function store(Request $request)
    {
        $data = [
            'user_id' => Auth::user()->id,
            'account_holder' => $request->account_holder,
            'card_number' => $request->card_number,
            'bank_name' => $request->bank_name,
            'iban' => $request->iban,
        ];
        $item = UserBankAccount::create($data);
        $data = ['user_bank_account' => $item];
        return MessageHelper::instance()->sendResponse('Successfully registered', $data, 201);
    }

    public function show($id)
    {
        $item = UserBankAccount::find($id);
        $data = ['user_bank_account' => $item];
        return MessageHelper::instance()->sendResponse('Successfully registered', $data, 200);
    }

    public function get_by_user()
    {
        // dd(Auth::user());
        $item = UserBankAccount::where('user_id', Auth::user()->id)->get();
        $data = ['user_bank_accounts' => $item];
        return MessageHelper::instance()->sendResponse('Successfully received', $data, 200);
    }

    public function get_account_info_by_iban(Request $request)
    {
        $user = Auth::user();
        // if ($request->iban == '000000000000000000000000') {
        //     $data = ['user_bank_account' => null];
        // } else {
        $data = ['user_bank_account' => [
            'iban' => $request->iban,
            'account_holder' => $user->name,
            'user_id' => $user->id,
            'card_number' => '',
            'bank_name' => 'بانک ملت'
        ]];
        // }
        return MessageHelper::instance()->sendResponse('Successfully registered', $data, 200);
    }

    public function update(Request $request)
    {
        // dd($request->all());
        $item = UserBankAccount::find($request->id);
        $dataList = [
            'account_holder' => $request->account_holder,
            'card_number' => $request->card_number,
            'bank_name' => $request->bank_name,
            'iban' => $request->iban,
        ];
        $item->update($dataList);
        $data = ['user_bank_account' => $item];
        return MessageHelper::instance()->sendResponse('Successfully Updated', $data, 200);
    }

    public function destroy($id)
    {
        $dataList = UserBankAccount::find($id);
        $dataList->delete();
        // $data = ["user_bank_account" => null];
        return MessageHelper::instance()->sendResponse('Successfully Deleted', null, 200);
    }
}
