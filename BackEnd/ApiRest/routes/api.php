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

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::apiResource('clients', 'ClientController');
Route::apiResource('sellers', 'SellerController');
Route::apiResource('products', 'ProductController');
// Route::apiResource('orders', 'OrderController');
Route::get('/orders', 'OrderController@index');
Route::get('/orders/{order}', 'OrderController@show');
Route::post('/orders', 'OrderController@store');
Route::patch('/orders/cancel/{order}', 'OrderController@cancel');
Route::patch('/orders/finish/{order}', 'OrderController@finish');