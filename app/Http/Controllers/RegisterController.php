<?php

namespace App\Http\Controllers;

use App\Helpers\MessageHelper;
use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Auth;
use Laravel\Passport\Passport;
use Validator;

class RegisterController extends Controller
{

//    public function __construct()
//    {
//        $this->middleware('auth:api', ['except' => ['login', 'register', 'profile','logout','refresh']]);
//    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255',
            'email' => 'email|unique:users|max:50',
            'password' => 'required|confirmed|string|min:6',
            'national_code' => 'required|string|size:10',
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'address' => 'string|max:500',
            'cell_phone' => 'required|unique:users|string|size:11'
        ]);

        if($validator->fails()){
            return MessageHelper::instance()->sendError('Validation Error.',$validator->errors(),422);
        }

        $input = $request->all();
        $input['password'] = bcrypt($input['password']);
        $user = User::create($input);
        $success['token'] =  $user->createToken('MyApp')->accessToken;
        $success['user'] =  $user;

        return MessageHelper::instance()->sendResponse('Successfully registered',$success,201);
    }

    public function login(Request $request)
    {
        if(Auth::attempt(['cell_phone' => $request->cell_phone, 'password' => $request->password])){

            $user = Auth::user();
            $success['token'] =  $user->createToken('MyApp')-> accessToken;
            $success['user'] =  $user;
            return MessageHelper::instance()->sendResponse('Successfully logged in',$success,200);
        }
        else{
            return MessageHelper::instance()->sendError('Unauthorized',[],401);
        }
    }

    public function logout()
    {
        if (Auth::user()) {
            Auth::user()->token()->update(['revoked' =>true]);
            return MessageHelper::instance()->sendResponse('Successfully logged out',[],200);
        }
        return MessageHelper::instance()->sendError('Unauthorized',[],401);
    }

    public function profile()
    {
        if (Auth::user()) {
            return MessageHelper::instance()->sendResponse('Successfully received',Auth::user(),200);
        }
        return MessageHelper::instance()->sendError('Unauthorized',[],401);
    }

    public function refresh()
    {
        if (Auth::user()) {
            $user = Auth::user();
            $user->token()->update(['revoked' =>true]);
            $success['token'] =  $user->createToken('MyApp')-> accessToken;
            $success['user'] =  $user;

            return MessageHelper::instance()->sendResponse('Token is Successfully Refreshed',$success,200);
        }
        return MessageHelper::instance()->sendError('Unauthorized',[],401);
    }

}
