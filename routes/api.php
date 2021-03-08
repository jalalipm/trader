<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

//Route::middleware('auth:api')->get('/user', function (Request $request) {
//    return $request->user();
//});


Route::post('Register', 'RegisterController@register');
Route::post('Login', 'RegisterController@login');
// Route::post('Logout', 'RegisterController@logout');

// Route::post('Register', 'RegisterController@store');
// Route::post('Login', 'RegisterController@login');
Route::get('CheckRegister', 'RegisterController@check_register');
Route::post('GetVerificationCode', 'RegisterController@get_verification_code');
Route::post('ForgetPass', 'RegisterController@forget_pass');

Route::middleware('auth:api')->group(function () {
    Route::post('Logout', 'RegisterController@logout');
    Route::get('Profile', 'RegisterController@profile');
    Route::post('Refresh', 'RegisterController@refresh');
    Route::put('UpdateUserProfile', 'RegisterController@update');
    Route::post('UpdateProfileAvatar', 'RegisterController@update_profile_avatar');
    Route::delete('DeleteProfileAvatar', 'RegisterController@delete_profile_avatar');
});

Route::Group(
    ['prefix' => 'v1', 'namespace' => 'api\v1'],
    function () {
        Route::get('ConTest', 'CommonController@contest');
        Route::get('PortfolioManagement', 'PortfolioManagementController@index');
        Route::get('PortfolioManagement/{id}', 'PortfolioManagementController@show');
        Route::get('PortfolioManagementInterest', 'PortfolioManagementController@interest');
        Route::get('StockData', 'StockDataController@index');
        Route::get('Faq', 'FaqController@index');
        Route::post('AnonymouslyTicket', 'UserTicketController@store');
        //test
        // Route::get('CallMethod', 'ReportController@call_method');
    }
);

Route::Group(
    ['prefix' => 'v1', 'namespace' => 'api\v1', 'middleware' => ['auth:api']],
    function () {
        //User

        Route::get('PortfolioManagementByUser', 'PortfolioManagementController@get_by_user');
        Route::delete('PortfolioManagement/{id}', 'PortfolioManagementController@destroy');
        // Route::get('PortfolioManagement', 'PortfolioManagementController@index');
        // Route::post('PortfolioManagement', 'PortfolioManagementController@store');
        // Route::put('PortfolioManagement/{id}', 'PortfolioManagementController@update');

        //StockData
        Route::post('StockData', 'StockDataController@store');
        // Route::get('StockData/{id}', 'StockDataController@show');
        // Route::put('StockData/{id}', 'StockDataController@update');
        // Route::delete('StockData/{id}', 'StockDataController@destroy');

        //Payment
        Route::get('PaymentByUser', 'PaymentController@get_by_user');
        Route::post('Payment', 'PaymentController@store');
        Route::get('PaymentDoPay', 'PaymentController@do_pay');
        Route::get('PaymentVerify', 'PaymentController@pay_verify');
        // Route::get('Payment/{id}', 'PaymentController@show');
        // Route::put('Payment/{id}', 'PaymentController@update');
        // Route::delete('Payment/{id}', 'PaymentController@destroy');

        //RefundRequest
        Route::get('RefundRequest/{id}', 'RefundRequestController@show');
        Route::get('RefundRequestByUser', 'RefundRequestController@get_by_user');
        Route::get('RefundRequest/GetByPortfolioManagement/{portfolio_management_id}', 'RefundRequestController@get_by_portfolio_management');
        Route::post('RefundRequest', 'RefundRequestController@store');
        Route::put('RefundRequest', 'RefundRequestController@update');
        Route::delete('RefundRequest/{id}', 'RefundRequestController@destroy');

        //UserBankAccount
        Route::get('UserBankAccount/{id}', 'UserBankAccountController@show');
        Route::post('GetAccountInfoByIban', 'UserBankAccountController@get_account_info_by_iban');
        Route::get('UserBankAccountByUser', 'UserBankAccountController@get_by_user');
        Route::post('UserBankAccount', 'UserBankAccountController@store');
        Route::put('UserBankAccount', 'UserBankAccountController@update');
        Route::delete('UserBankAccount/{id}', 'UserBankAccountController@destroy');

        //UserTicket
        Route::get('UserTicket/{id}', 'UserTicketController@show');
        Route::get('UserTicketByUser', 'UserTicketController@get_by_user');
        Route::post('UserTicket', 'UserTicketController@store');
        // Route::put('UserTicket', 'UserTicketController@update');
        // Route::delete('UserTicket/{id}', 'UserTicketController@destroy');

        //UserTicketResponce
        Route::get('UserTicketResponseByTicketID/{id}', 'UserTicketResponseController@get_by_ticket_id');
        Route::post('UserTicketResponse', 'UserTicketResponseController@store');
        // Route::get('UserTicketResponse/{id}', 'UserTicketResponseController@show');
        // Route::put('UserTicketResponse', 'UserTicketResponseController@update');
        // Route::delete('UserTicketResponse/{id}', 'UserTicketResponseController@destroy');

        //Dashboard
        Route::get('GetDashboard', 'DashboardController@get_dashboard');

        //Message
        Route::get('Message/{id}', 'MessageController@show');
        Route::get('MessageByUser', 'MessageController@get_by_user');
        Route::post('MessageRead', 'MessageController@message_read');

        //Message
        Route::get('UserDocumentByUser', 'UserDocumentController@get_by_user');
        Route::post('UserDocument', 'UserDocumentController@store');
        Route::delete('UserDocument/{id}', 'UserDocumentController@destroy');

        //Report
        Route::post('CostBenefitReport', 'ReportController@cost_benefit_report');
    }
);
