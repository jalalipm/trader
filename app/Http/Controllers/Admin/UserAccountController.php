<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Model\UserAccount;
use Illuminate\Http\Request;

class UserAccountController extends Controller
{
    // public function index()
    // {
    //     return view('admin.user_accounts.index');
    // }

    public function anyData($user_id)
    {
        $user_accounts = UserAccount::GetByUserID($user_id)->get();
        return datatables()->of($user_accounts)->make(true);
    }

    // public function create($user_id)
    // {
    //     return view('admin.users.partial.bank-account.form-modal', compact('user_id'));
    // }

    // public function store(Request $request)
    // {
    //     $user_account_data = [
    //         'user_id' => request()->input('user_id'),
    //         'account_holder' => request()->input('account_holder'),
    //         'card_number' => request()->input('card_number'),
    //         'bank_name' => request()->input('bank_name'),
    //         'iban' => request()->input('iban'),
    //     ];

    //     $new_user_accounts = UserAccount::create($user_account_data);
    //     if ($new_user_accounts instanceof UserAccount) {
    //         return response('create', 200);
    //     }
    //     return response(false, 400);
    // }

    // public function edit($id)
    // {
    //     if ($id && ctype_digit($id)) {
    //         $user_account = UserAccount::find($id);
    //         $user_id = $user_account->user_id;
    //         if ($user_account && $user_account instanceof UserAccount) {
    //             return view('admin.users.partial.bank-account.form-modal', compact('user_account', 'user_id'));
    //         }
    //     }
    // }

    // public function update(Request $request)
    // {
    //     $user_accounts_item = UserAccount::find($request->id);
    //     $input = request()->except('_token');
    //     $user_accounts_item->update($input);
    //     return response('update', 200);
    // }

    // public function destroy($id)
    // {
    //     if ($id && ctype_digit($id)) {
    //         $user_accounts = UserAccount::find($id);
    //         if ($user_accounts && $user_accounts instanceof UserAccount) {
    //             $user_accounts->delete();
    //         }
    //     }
    // }
}
