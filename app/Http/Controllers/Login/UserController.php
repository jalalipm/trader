<?php

namespace App\Http\Controllers\Login;

use App\Http\Requests\UserRequest;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function login()
    {
        return view('auth.login');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function doLogin(Request $request)
    {
        //        dd($request);
        $remember = $request->has('remember');
        if (Auth::attempt([
            'email' => $request->input('email'),
            'password' => $request->input('password')
        ], $remember)) {
            return redirect()->route('admin.dashboard');
            // return view('admin.dashboard.index');
        }
        return redirect()->back()->with('loginError', 'نام کاربری یا کلمه عبور اشتباه می باشد');
    }

    public function register()
    {
        return view('auth.register');
    }

    public function doRegister(Request $request)
    {
        $user_data = [
            // 'name' => request()->input('name'),
            'last_name' => request()->input('last_name'),
            'first_name' => request()->input('first_name'),
            'cell_phone' => request()->input('cell_phone'),
            'email' => request()->input('email'),
            'password' => bcrypt(request()->input('password')),
            // 'kind' => 3
        ];
        $new_user = User::create($user_data);
        if ($new_user instanceof User) {
            //            return redirect('/');
            return redirect()->route('admin.dashboard');
        }
        return redirect()->back()->with('loginError', 'نام کاربری یا کلمه عبور اشتباه است');
    }

    public function RecoverPass()
    {
        return view('auth.passwords.reset');
    }

    public function doRecoverPass()
    {
        dd(123);
    }

    public function logout()
    {
        Auth::logout();
        return redirect('/');
    }
}
