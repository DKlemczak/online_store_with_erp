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

Route::get('/','App\Http\Controllers\StaticController@index')->name('index');

Route::get('/products/{id}','App\Http\Controllers\ProductController@index')->name('products');
Route::get('/products/group-{group_id}/product-{id}','App\Http\Controllers\ProductController@details')->name('products.details');
Auth::routes();
