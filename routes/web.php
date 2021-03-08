<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::group(['namespace' => 'Login'/*, 'middleware'=>'admin'*/], function () {
    Route::get('/', 'HomeController@index')->name('home');
    Route::get('/login', 'UserController@login')->name('login');
    Route::post('/login', 'UserController@doLogin')->name('post.login');
    Route::get('/register', 'UserController@register')->name('register');
    Route::post('/register', 'UserController@doRegister')->name('post.register');
    Route::get('/logout', 'UserController@logout')->name('logout');
    //reset password
    Route::get('/recoverpassword', 'UserController@RecoverPass')->name('recover-password');
});
// Route::get('password/email', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('reset');
// Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('post.sendResetLinkEmail');
// Password reset routes...ap
// Route::get('password/reset/{token?}', 'Auth\ResetPasswordController@showResetForm')->name('password.request');
// Route::post('password/reset', 'Auth\ResetPasswordController@reset')->name('password.reset');

Route::group(['prefix' => 'admin', 'namespace' => 'Admin', 'middleware' => 'admin'], function () { // /admin/users
    Route::get('/dashboard', 'DashboardController@index')->name('admin.dashboard');

    //User
    Route::resource('/users', 'UserController', ['names' => [
        'index' => 'admin.users.list',
        'create' => 'admin.users.create',
        'edit' => 'admin.users.edit',
        'store' => 'admin.users.store',
        'destroy' => 'admin.users.delete'
    ]]);
    Route::post('/user/update', 'UserController@update')->name('admin.users.update');
    Route::get('/user/anyData', 'UserController@anyData')->name('admin.users.anyData');
    // Route::get('/user/pushUpdate/{id}/{push_id}', 'UserController@pushUpdate')->name('admin.users.pushUpdate');
    Route::POST('/user/push-update', 'UserController@push_update')->name('admin.users.push-update');


    //UserBankAccount
    Route::resource('/user_bank_accounts', 'UserBankAccountController', ['names' => [
        'index' => 'admin.user_bank_accounts.list',
        // 'create' => 'admin.user_bank_accounts.create',
        'edit' => 'admin.user_bank_accounts.edit',
        'store' => 'admin.user_bank_accounts.store',
        'destroy' => 'admin.user_bank_accounts.delete'
    ]]);
    Route::post('/user_bank_account/update', 'UserBankAccountController@update')->name('admin.user_bank_accounts.update');
    Route::get('/user_bank_accounts/anyData/{user_id}', 'UserBankAccountController@anyData')->name('admin.user_bank_accounts.anyData');
    Route::get('/user_bank_accounts/create/{user_id}', 'UserBankAccountController@create')->name('admin.user_bank_accounts.create');

    //UserAccount
    Route::get('/user_accounts/anyData/{user_id}', 'UserAccountController@anyData')->name('admin.user_accounts.anyData');

    //DraftOrder
    Route::get('/draft_orders/anyData/{user_id}', 'DraftOrderController@anyData')->name('admin.draft_orders.anyData');
    Route::post('/draft_orders/send_to_order', 'DraftOrderController@send_to_order')->name('admin.draft_orders.send_to_order');


    //PortfolioManagement
    Route::resource('/portfolio_managements', 'PortfolioManagementController', ['names' => [
        'index' => 'admin.portfolio_managements.list',
        'create' => 'admin.portfolio_managements.create',
        'edit' => 'admin.portfolio_managements.edit',
        'store' => 'admin.portfolio_managements.store',
        'destroy' => 'admin.portfolio_managements.delete'
    ]]);
    Route::post('/portfolio_management/update', 'PortfolioManagementController@update')->name('admin.portfolio_managements.update');
    Route::get('/portfolio_anyData', 'PortfolioManagementController@anyData')->name('admin.portfolio_managements.anyData');

    //PortfolioDailyTrade
    Route::resource('/portfolio_daily_trades', 'PortfolioDailyTradeController', ['names' => [
        'index' => 'admin.portfolio_daily_trades.list',
        'edit' => 'admin.portfolio_daily_trades.edit',
        'store' => 'admin.portfolio_daily_trades.store',
        'destroy' => 'admin.portfolio_daily_trades.delete'
    ]]);
    Route::post('/portfolio_daily_trade/update', 'PortfolioDailyTradeController@update')->name('admin.portfolio_daily_trades.update');
    Route::get('/portfolio_daily_trades/anyData/{portfolio_management_id}', 'PortfolioDailyTradeController@anyData')->name('admin.portfolio_daily_trades.anyData');
    Route::get('/portfolio_daily_trades/create/{portfolio_management_id}', 'PortfolioDailyTradeController@create')->name('admin.portfolio_daily_trades.create');


    //FAQ
    Route::resource('/faqs', 'FaqController', ['names' => [
        'index' => 'admin.faqs.list',
        'create' => 'admin.faqs.create',
        'edit' => 'admin.faqs.edit',
        'store' => 'admin.faqs.store',
        'destroy' => 'admin.faqs.delete'
    ]]);
    Route::post('/faq/update', 'FaqController@update')->name('admin.faqs.update');
    Route::get('/faq/anyData', 'FaqController@anyData')->name('admin.faqs.anyData');

    //Payment
    Route::get('/payments', 'PaymentController@index')->name('admin.payments.list');
    Route::get('/payments/anyData', 'PaymentController@anyData')->name('admin.payments.anyData');

    //Message
    Route::resource('/messages', 'MessageController', ['names' => [
        'index' => 'admin.messages.list',
        'create' => 'admin.messages.create',
        'edit' => 'admin.messages.edit',
        'store' => 'admin.messages.store',
        'destroy' => 'admin.messages.delete',
    ]]);
    Route::get('/user_message/anyData', 'MessageController@anyData')->name('admin.messages.anyData');
    Route::post('/user_message/send-to-all', 'MessageController@send_to_all')->name('admin.messages.send-to-all');
    Route::Post('/messages/update', 'MessageController@update')->name('admin.messages.update');

    //UserTicket
    Route::resource('/user_tickets', 'UserTicketController', ['names' => [
        'edit' => 'admin.user_tickets.edit',
    ]]);
    Route::get('/user_tickets', 'UserTicketController@index')->name('admin.user_tickets.list');
    Route::get('/user_ticket/anyData', 'UserTicketController@anyData')->name('admin.user_tickets.anyData');
    Route::post('/user_response_ticket', 'UserTicketController@store_user_response_ticket')->name('admin.user-response-ticket.store');

    //Refound Request
    Route::resource('/refund_requests', 'RefundRequestController', ['names' => [
        'index' => 'admin.refund_requests.list',
        'create' => 'admin.refund_requests.create',
        'edit' => 'admin.refund_requests.edit',
        'store' => 'admin.refund_requests.store',
        'destroy' => 'admin.refund_requests.delete'
    ]]);
    Route::post('/refund_request/update', 'RefundRequestController@update')->name('admin.refund_requests.update');
    Route::get('/refund_request/anyData', 'RefundRequestController@anyData')->name('admin.refund_requests.anyData');

    //Report
    Route::get('/report', 'ReportController@index')->name('admin.reports.list');
    Route::post('/report/cost_benefit', 'ReportController@cost_benefit_report')->name('admin.reports.cost-benefit-report');
    Route::get('/report/cost_benefit_any_data/{condition}', 'ReportController@cost_benefit_report_any_data')->name('admin.reports.cost-benefit-report-any-data');
});
