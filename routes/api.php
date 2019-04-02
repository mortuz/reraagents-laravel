<?php

use Illuminate\Http\Request;

// use API\Citi

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

Route::get('/cities', 'API\CitiesController@citiesFromState')->name('get.cities');
Route::get('/ventures', 'API\VentureController@venturesFromCity')->name('get.ventures');
