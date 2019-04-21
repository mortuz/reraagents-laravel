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

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

// Route::group(['middleware' => 'auth:api'], function() {
    // Route::get('/user', 'API\UserController@user')->name('api.user');
// });

Route::group(['middleware' => 'auth:api'], function () {
    Route::get('/user', 'API\UserController@user')->name('api.user');

    Route::get('properties/my', 'API\PropertyController@my');
    Route::get('properties', 'API\PropertyController@index');
    Route::post('property/store', 'API\PropertyController@store');
    Route::post('property/update/{property}', 'API\PropertyController@update');
    Route::get('property/view', 'API\PropertyController@view');
    Route::get('property/premium/call', 'API\PropertyController@premiumCall');
    Route::get('property/office', 'API\PropertyController@office');
    
    Route::apiResource('certificate', 'API\CertificatesController');
});
Route::get('/property/premium/details', 'API\PropertyController@premiumDetail');
Route::post('/auth/recover/password', 'API\AuthController@recoverPassword');


Route::post('/register', 'API\AuthController@register')->name('api.auth.register');

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
Route::get('/states', 'API\StatesController@index')->name('api.state.index');
