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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();
Route::get('/', 'App\Http\Controllers\Site\ProductController@show')->name('product.show');
Route::get('/home', 'App\Http\Controllers\Site\ProductController@show')->name('product.show');
Route::get('/product-details/{id}', 'App\Http\Controllers\Site\ProductController@productDetail')->name('product.detail');
Route::get('/products-purchase/{id}', 'App\Http\Controllers\Site\ProductController@productsPurchase')->name('products.purchase');
Route::post('/process-payment/{string}/{price}', 'App\Http\Controllers\Site\ProductController@processPayment')->name('process.payment');
Route::get('/my-orders', 'App\Http\Controllers\Site\ProductController@myOrders')->name('products.orders');

