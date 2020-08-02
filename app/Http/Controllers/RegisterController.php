<?php

namespace App\Http\Controllers;

use App\Helpers\MessageHelper;
use App\Helpers\Sms\Smsir;
use Illuminate\Http\Request;
use App\User;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\Auth;
use Laravel\Passport\Passport;
use phpseclib\Crypt\Random;
use Validator;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\URL;

// use SmsIR_VerificationCode;

class RegisterController extends Controller
{

    //    public function __construct()
    //    {
    //        $this->middleware('auth:api', ['except' => ['login', 'register', 'profile','logout','refresh']]);
    //    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            // 'name' => 'required|max:255',
            'email' => 'email|unique:users|max:50',
            'password' => 'required|string|min:6',
            'national_code' => 'required|string|size:10',
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'address' => 'string|max:500',
            'cell_phone' => 'required|unique:users|string|size:11'
        ]);

        if ($validator->fails()) {
            return MessageHelper::instance()->sendError('Validation Error.', $validator->errors(), 422);
        }

        $input = $request->all();
        $input['name'] = $input['first_name'] . ' ' . $input['last_name'];
        $input['password'] = bcrypt($input['password']);
        $user = User::create($input);
        $success['token'] =  $user->createToken('MyApp')->accessToken;
        $success['user'] =  $user;

        return MessageHelper::instance()->sendResponse('Successfully registered', $success, 201);
    }

    public function login(Request $request)
    {
        if (Auth::attempt(['cell_phone' => $request->cell_phone, 'password' => $request->password])) {

            $user = Auth::user();
            $success['token'] =  $user->createToken('MyApp')->accessToken;
            $success['user'] =  $user;
            return MessageHelper::instance()->sendResponse('Successfully logged in', $success, 200);
        } else {
            return MessageHelper::instance()->sendError('Unauthorized', [], 401);
        }
    }

    public function logout()
    {
        if (Auth::user()) {
            Auth::user()->token()->update(['revoked' => true]);
            return MessageHelper::instance()->sendResponse('Successfully logged out', [], 200);
        }
        return MessageHelper::instance()->sendError('Unauthorized', [], 401);
    }

    public function profile()
    {
        if (Auth::user()) {
            $data = ['user' => Auth::user()];
            return MessageHelper::instance()->sendResponse('Successfully received', $data, 200);
        }
        return MessageHelper::instance()->sendError('Unauthorized', [], 401);
    }

    public function update(Request $request)
    {
        $input_first_name = $request->json()->get('first_name');
        $input_last_name = $request->json()->get('last_name');
        $input_email = $request->json()->get('email');
        $input_national_code = $request->json()->get('national_code');
        $input_address = $request->json()->get('address');
        $input_postal_code = $request->json()->get('postal_code');
        // $input_cell_phone = $request->json()->get('cell_phone');
        if (!$request->json()->has('password')) {
            $dataList = [
                'name' => $input_first_name . ' ' . $input_last_name,
                'first_name' => $input_first_name,
                'last_name' => $input_last_name,
                'email' => $input_email,
                'national_code' => $input_national_code,
                'address' => $input_address,
                'postal_code' => $input_postal_code
            ];
        } else {
            $input_password = $request->json()->get('password');
            $dataList = [
                'password' => bcrypt($input_password)
            ];
        }

        try {
            if (Request()->hasFile('avatar')) {
                // $user = User::find($user_id);
                $timestamp = Carbon::now(new \DateTimeZone('Asia/Tehran'))->timestamp;
                $new_name = $input_first_name . ' ' . $input_last_name . $timestamp . '_' . request()->file('avatar')->getClientOriginalName();
                $file_path = request()->file('avatar')->move(public_path('files/users'), $new_name);
                if ($file_path instanceof \Symfony\Component\HttpFoundation\File\File) {
                    $dataList['avatar'] = url("/files/users/{$new_name}");
                }
            }
            $UserUpdating = User::find(Auth::user()->id);
            $UserUpdating->update($dataList);
            // $UserUpdated = User::find($UserUpdating->id);
            $data = ['user' => $UserUpdating];
            return MessageHelper::instance()->sendResponse('your profile is updated', $data, 200);
        } catch (QueryException $ex) {
            $string = $ex->getMessage();
            return MessageHelper::instance()->sendError('error while updating data', $string, 400);
        }
    }

    public function delete_profile_avatar(Request $request)
    {

        $input_user_id = $request->json()->get('user_id');
        try {
            $user = User::find($input_user_id);
            $base_url = URL::to('/');
            $file_name = public_path() . substr($user->avatar, strlen($base_url));
            $user->update(['avatar' => null]);
            if (file_exists($file_name))
                unlink($file_name);
            $List = User::find($input_user_id);
            $data = ['user' => $user];
            return MessageHelper::instance()->sendResponse('your profile is updated', $data, 200);
            // return response()->json(['code' => '1002', 'message' => 'data was successfully deleted', 'user' => $List], 200, [], JSON_UNESCAPED_UNICODE);
        } catch (QueryException $ex) {
            $string = $ex->getMessage();
            return MessageHelper::instance()->sendError('error while updating data', $string, 400);
            // return response()->json(['code' => '1004', 'message' => 'error while deleting data', 'errors' => $string], 400);
        }
    }

    public function refresh()
    {
        if (Auth::user()) {
            $user = Auth::user();
            $user->token()->update(['revoked' => true]);
            $success['token'] =  $user->createToken('MyApp')->accessToken;
            $success['user'] =  $user;

            return MessageHelper::instance()->sendResponse('Token is Successfully Refreshed', $success, 200);
        }
        return MessageHelper::instance()->sendError('Unauthorized', [], 401);
    }

    public function forget_pass(Request $request)
    {
        $input_password = $request->json()->get('password');
        $input_phone = $request->json()->get('cell_phone');
        $dataList = [
            'password' => bcrypt($input_password)
        ];
        $ListItem = User::where('cell_phone', $input_phone)->first();
        $user = Auth::user();
        try {
            $ListItem->update($dataList);
            if (Auth::attempt(['cell_phone' => $input_phone, 'password' => $input_password])) {
                $user = Auth::user();
                if (Auth::user()) {
                    // dd($user->tokens()->where('revoked', 0)->get());
                    $userTokens = Auth::user()->tokens()->where('revoked', 0)->get();
                    foreach ($userTokens as $token) {
                        $token->revoke();
                    }
                }
                $data = [
                    'token' => $user->createToken('MyApp')->accessToken,
                    'user' => Auth::user()
                ];
                return MessageHelper::instance()->sendResponse('your password was successfully changed', $data, 200);
            } else {
                return MessageHelper::instance()->sendError('Unauthorized', [], 401);
            }
        } catch (QueryException $ex) {
            $string = $ex->getMessage();
            return MessageHelper::instance()->sendError('error while inserting data', $string, 400);
        }
    }

    public function check_register(Request $request)
    {
        $input_phone = $request->cell_phone;
        $user = User::where('cell_phone', $input_phone)->first();
        if (isset($user) && $user != null) {
            $data = ['status' => true];
            return MessageHelper::instance()->sendResponse('the phone has already been existed', $data, 200);
        }
        $data = ['status' => false];
        return MessageHelper::instance()->sendResponse('the phone not found', $data, 200);
    }

    public function get_verification_code(Request $request)
    {
        $input_phone = $request->json()->get('cell_phone');
        $ValidStr = ['phone' => $input_phone];
        $validation = Validator::make($ValidStr, [
            'phone' => 'required|regex:/(09)[0-9]{9}/',
        ]);
        if ($validation->fails()) {
            $errors = $validation->errors();
            return MessageHelper::instance()->sendError('Validation Error', $errors, 422);
        } else {
            $rand_number = random_int(10000, 99999);
            try {
                // Smsir::sendVerification($rand_number, $input_phone);
                // Smsir::send_verification($rand_number, $input_phone);
                Smsir::send_verification($rand_number, $input_phone);
                $data = ['verify_code' => $rand_number];
                return MessageHelper::instance()->sendResponse('verification code is sent', $data, 200);
                // return response()->json(['code' => '1002', 'message' => 'verification code is sent', 'VerifyCode' => $rand_number], 200, [], JSON_UNESCAPED_UNICODE);
            } catch (Exception $e) {
                // return response()->json(['code' => '1008', 'message' => 'sms not sent', 'errors' => 'sms problem'], 400);
                return MessageHelper::instance()->sendError('sms not sent', [], 400);
            }
        }
    }
}
