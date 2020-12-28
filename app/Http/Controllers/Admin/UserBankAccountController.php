<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Model\UserBankAccount;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;

class UserBankAccountController extends Controller
{
    public function index()
    {
        return view('admin.user_bank_accounts.index');
    }

    public function anyData($user_id)
    {
        $user_bank_accounts = UserBankAccount::where('user_id', $user_id)->get();
        return datatables()->of($user_bank_accounts)
            ->addColumn('action', function ($user_bank_account) {
                return view('admin.users.partial.bank-account.operations', compact('user_bank_account'));
            })->make(true);
    }

    public function create($user_id)
    {
        return view('admin.users.partial.bank-account.form-modal', compact('user_id'));
    }

    public function store(Request $request)
    {
        $user_bank_account_data = [
            'user_id' => request()->input('user_id'),
            'account_holder' => request()->input('account_holder'),
            'card_number' => request()->input('card_number'),
            'bank_name' => request()->input('bank_name'),
            'iban' => request()->input('iban'),
        ];

        $new_user_bank_accounts = UserBankAccount::create($user_bank_account_data);
        if ($new_user_bank_accounts instanceof UserBankAccount) {
            return response('create', 200);
        }
        return response(false, 400);
    }

    public function edit($id)
    {
        if ($id && ctype_digit($id)) {
            $user_bank_account = UserBankAccount::find($id);
            $user_id = $user_bank_account->user_id;
            if ($user_bank_account && $user_bank_account instanceof UserBankAccount) {
                return view('admin.users.partial.bank-account.form-modal', compact('user_bank_account', 'user_id'));
            }
        }
    }

    public function update(Request $request)
    {
        $user_bank_accounts_item = UserBankAccount::find($request->id);
        $input = request()->except('_token');
        $user_bank_accounts_item->update($input);
        return response('update', 200);
    }

    public function destroy($id)
    {
        if ($id && ctype_digit($id)) {
            $user_bank_accounts = UserBankAccount::find($id);
            if ($user_bank_accounts && $user_bank_accounts instanceof UserBankAccount) {
                $user_bank_accounts->delete();
            }
        }
    }
}
