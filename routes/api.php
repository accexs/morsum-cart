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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/products', 'ProductController@index');
Route::post('/orders', 'OrderController@store');

Route::get('/cart', 'CartController@getItems');
Route::patch('/cart/addItem', 'CartController@addItem');
Route::patch('/cart/removeItem', 'CartController@removeItem');
Route::delete('/cart', 'CartController@destroy');
