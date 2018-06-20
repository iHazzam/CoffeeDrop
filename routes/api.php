<?php

use Illuminate\Http\Request;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});



Route::get('location/postcode','LocationController@search')->name('location.search');
Route::post('location','LocationController@store')->name('location.store');
Route::post('products/quote','ProductController@quote')->name('products.quote');
Route::get('locations','LocationController@index')->name('location.index');