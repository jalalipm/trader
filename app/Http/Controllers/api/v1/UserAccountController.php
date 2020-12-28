<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use App\Model\UserAccount;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserAccountController extends Controller
{

    public function index()
    {
        //
    }

    public function store($request)
    {
        $result = UserAccount::insert($request);
        return $result;
    }

    public function show(UserAccount $userAccount)
    {
        //
    }

    public function update(Request $request, UserAccount $userAccount)
    {
        //
    }

    public function destroy(UserAccount $userAccount)
    {
        //
    }
}
