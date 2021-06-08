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
Route::get('/products/{name}/product-{id}','App\Http\Controllers\ProductController@details')->name('products.details');
Route::post('/addtocart','App\Http\Controllers\CartController@addtocart')->name('cart.addtocart');
Route::get('/cart','App\Http\Controllers\CartController@index')->name('cart');
Route::get('/cart/removefromcart/{id}','App\Http\Controllers\CartController@removefromcart')->name('cart.remove');
Route::post('/cart/summary','App\Http\Controllers\CartController@summary')->name('cart.summary');
Route::get('/cart/createorder','App\Http\Controllers\CartController@createorder')->name('cart.createorder');

Route::group(['middleware' => 'auth'], function()
{
    Route::get('/user', 'App\Http\Controllers\UserController@index')->name('user');
    Route::get('/user/data', 'App\Http\Controllers\UserController@userdata')->name('user.data');
    Route::post('/user/savedata', 'App\Http\Controllers\UserController@savedata')->name('user.savedata');

});

Route::group(['middleware' => 'admin'], function ()
{
    Route::get("/dashboard", "App\Http\Controllers\Dashboard\DashboardController@index")->name('dashboard');

    Route::resource('dashboard/products', 'App\Http\Controllers\Dashboard\ProductsController', ['except'=>['show'], 'names' => [
        'index'   => 'dashboard.products.index'
    ]], ['except' => ['show']])->middleware(['auth', 'admin']);

    Route::resource('dashboard/products/{id}/photos', 'App\Http\Controllers\Dashboard\ProductPhotosController', ['except'=>['show'], 'names' => [
        'index'   => 'dashboard.products.photos.index',
        'create'  => 'dashboard.products.photos.create',
        'store'   => 'dashboard.products.photos.store',
        'destroy' => 'dashboard.products.photos.destroy'
    ]], ['except' => ['show']])->middleware(['auth', 'admin']);

});
Auth::routes();
