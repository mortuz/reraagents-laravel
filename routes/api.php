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
Route::get('/ventures/city', 'API\VentureController@venturesFromCity')->name('api.get.ventures');
Route::get('/faces', 'API\FaceController@index')->name('api.faces.index');
Route::get('/bhk', 'API\BHKController@index')->name('api.bhk.index');
Route::get('/property-type', 'API\PropertyTypeController@index')->name('api.propertytype.index');
Route::get('/agents', 'API\AgentsController@index')->name('api.agents.index');
Route::get('/builders', 'API\BuildersController@index')->name('api.builders.index');
Route::get('/ventures', 'API\VentureController@index')->name('api.venture.index');
Route::get('/area', 'API\AreaController@index')->name('api.area.index');
Route::get('/landmark', 'API\LandmarkController@index')->name('api.landmark.index');
Route::get('/price', 'API\PriceController@index')->name('api.price.index');

// area controller, landmark controller
