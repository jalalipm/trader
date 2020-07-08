<?php

namespace App\Http\Controllers;

//use Illuminate\Support\Facades\Auth;
use App\Helpers\MessageHelper;
use App\Http\Controllers\Controller;
use Tymon\JWTAuth\Exceptions\JWTException;
use Validator;
use Illuminate\Http\Request;
use App\User;

class JWTAuthController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login', 'register', 'profile','logout','refresh']]);
    }


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

        if ($validator->fails()) {
            return MessageHelper::instance()->sendError('Validation Error.',$validator->errors(),422);
        }

        $user = User::create(array_merge(
            $validator->validated(),
            ['password' => bcrypt($request->password)]
        ));

        return MessageHelper::instance()->sendResponse('Successfully registered',$user,201);
    }


    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'cell_phone' => 'required|string|size:11',
            'password' => 'required|string|min:6',
        ]);

        if ($validator->fails()) {
            return MessageHelper::instance()->sendError('Validation Error.',$validator->errors(),422);
        }

        if (! $token = auth()->attempt($validator->validated())) {
            return MessageHelper::instance()->sendError('Unauthorized',[],401);
        }

        return MessageHelper::instance()->sendResponse('Successfully logged in',$this->createNewToken($token)->original,200);
    }


    public function profile()
    {
        if(auth()->user()){
        return MessageHelper::instance()->sendResponse('Successfully received',auth()->user(),200);
        }
        return MessageHelper::instance()->sendError('Unauthorized',[],401);
    }


    public function logout()
    {
        auth()->logout();
        return MessageHelper::instance()->sendResponse('Successfully logged out',[],200);
    }


    public function refresh()
    {
        try {
            $newToken= $this->createNewToken(auth()->refresh());
            return MessageHelper::instance()->sendResponse('Successfully received',$newToken->original,200);
        } catch (JWTException $e){
            return MessageHelper::instance()->sendError('Unauthorized',$e->getMessage(),401);
        }
    }

    protected function createNewToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 3600
        ]);
    }
}
