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


Route::post('register', 'RegisterController@register');
Route::post('login', 'RegisterController@login');
Route::post('logout', 'RegisterController@logout');
Route::middleware('auth:api')->group( function () {
    Route::post('logout', 'RegisterController@logout');
    Route::get('profile', 'RegisterController@profile');
    Route::post('refresh', 'RegisterController@refresh');
});

Route::Group(
    ['prefix' => 'v1', 'namespace' => 'api\v1'],
    function () {
        Route::get('PortfolioManagementInterest', 'PortfolioManagementController@interest');
        Route::get('StockData', 'StockDataController@index');
    }
);

Route::Group(
    ['prefix' => 'v1', 'namespace' => 'api\v1', 'middleware' => ['auth:api']],
    function () {
        Route::get('PortfolioManagement', 'PortfolioManagementController@index');
        Route::get('PortfolioManagement/{id}', 'PortfolioManagementController@show');
        Route::post('PortfolioManagement', 'PortfolioManagementController@store');
        Route::put('PortfolioManagement/{id}', 'PortfolioManagementController@update');
        Route::delete('PortfolioManagement/{id}', 'PortfolioManagementController@destroy');

        //StockData
        Route::get('StockData/{id}', 'StockDataController@show');
        Route::post('StockData', 'StockDataController@store');
        Route::put('StockData/{id}', 'StockDataController@update');
        Route::delete('StockData/{id}', 'StockDataController@destroy');

        //Payment
        Route::get('Payment', 'PaymentController@index');
        Route::get('Payment/{id}', 'PaymentController@show');
        Route::post('Payment', 'PaymentController@store');
        Route::put('Payment/{id}', 'PaymentController@update');
        Route::delete('Payment/{id}', 'PaymentController@destroy');
    }
);
