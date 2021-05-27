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

Route::middleware('ApiToken')->group(function ()
{
    Route::get('/orders', 'App\Http\Controllers\Api\OrdersController@index');
    Route::post('/orders/setstatus','App\Http\Controllers\Api\OrdersController@setStatus');
    Route::post('/products','App\Http\Controllers\Api\ProductsController@index');
    Route::post('/productsgroup','App\Http\Controlles\Api\ProductsGroup@index');
    Route::post('/user/setenovacode','App\Http\Controllers\Api\UserController@setenovacode');
});
