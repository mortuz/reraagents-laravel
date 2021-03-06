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

Route::post('/user/check-role', 'API\UserController@checkRole');
Route::get('/auth/check', 'API\AuthController@authCheck');

Route::group(['middleware' => 'auth:api'], function () {
    Route::get('/user', 'API\UserController@user')->name('api.user');
    Route::post('/profile/update', 'API\UserController@profileUpdate');
    Route::post('/profile/avatar', 'API\UserController@updateAvatar');
    Route::post('/expo-token/store', 'API\ExpoTokenController@store');
    Route::post('/logout', 'API\UserController@logoutApi');

    Route::apiResource('call-records', 'API\CallRecordsController');
    Route::get('/call-record/find', 'API\CallRecordsController@find');

    Route::get('properties/my', 'API\PropertyController@my');
    Route::get('properties', 'API\PropertyController@index');
    Route::post('property/store', 'API\PropertyController@store');
    Route::post('property/delete', 'API\PropertyController@destroy');
    Route::post('property/update/{property}', 'API\PropertyController@update');
    Route::get('property/view', 'API\PropertyController@view');
    Route::get('property/premium/call', 'API\PropertyController@premiumCall');
    Route::get('property/office', 'API\PropertyController@office');
    Route::post('property/renew', 'API\PropertyController@renew');

    Route::post('/premium/request', 'API\PremiumAdRequestsController@store');

    Route::get('requirements', 'API\RequirementController@index');
    Route::get('requirements/my', 'API\RequirementController@my');
    Route::post('requirement/call-working-agent', 'API\RequirementController@callworkingAgent');
    Route::post('requirement/view', 'API\RequirementController@view');
    Route::post('requirement/store', 'API\RequirementController@store');
    Route::get('requirement/office', 'API\RequirementController@office');
    Route::post('requirement/release', 'API\RequirementController@release');
    Route::get('requirements/working', 'API\RequirementController@working');
    Route::get('requirement/show', 'API\RequirementController@show');
    Route::post('requirement/call', 'API\RequirementController@call');
    Route::post('requirement/delete', 'API\RequirementController@destroy');
    Route::post('requirement/update-details', 'API\RequirementController@updateDetails');
    Route::get('requirement/get-comments', 'API\RequirementMessageController@show');
    Route::post('requirement/post-comment', 'API\RequirementMessageController@store');
    
    Route::post('/office', 'API\OfficesController@store');
    Route::get('/office', 'API\OfficesController@index');
    Route::apiResource('certificate', 'API\CertificatesController');
    Route::apiResource('finance', 'API\FinanceController');
    Route::get('/finances', 'API\FinanceController@index');
    Route::post('/finances/store', 'API\FinanceController@store');

});

Route::get('/designation', 'API\DesignationController@index')->name('api.designation.index');

Route::get('/loan-purposes', 'API\LoanPurposeController@index');
Route::get('/property/premium/details', 'API\PropertyController@premiumDetail');
Route::post('/auth/recover/password', 'API\AuthController@recoverPassword');

Route::post('property/guest-post', 'API\PropertyController@postGuestProperty')->name('post.guest.property');
Route::post('requirement/guest-post', 'API\RequirementController@postGuestRequirement')->name('post.guest.requirement');

Route::post('/reg', 'API\AuthController@reg1')->name('api.auth.register');

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

Route::get('/area-by-city', 'API\AreaController@getAreaByCity');


Route::group(['middleware' => 'adminToken'], function() {
    Route::post('/area/store', 'API\AreaController@store')->name('api.area.store');
    Route::post('/landmark/store', 'API\LandmarkController@store')->name('api.landmark.store');
    Route::post('/price/store', 'API\PriceController@store')->name('api.price.store');
    Route::post('/venture/store', 'API\VentureController@store')->name('api.venture.store');
    Route::get('/office/fetch-office', 'API\OfficesController@fetchOffice')->name('api.office.index');
    Route::post('/designation', 'API\DesignationController@store')->name('api.designation.store');
    Route::get('/admin/premium/property', 'API\PropertyController@getPremiumProperty')->name('api.admin.premium.property');
    Route::post('/admin/premium/property', 'API\PropertyController@postPremiumProperty');
    Route::get('/admin/amenities', 'API\AmenityController@index')->name('api.admin.amenity.index');
});