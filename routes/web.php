<?php

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

Route::get('/', 'FrontendController@index')->name('index');
Route::get('/about', 'FrontendController@about')->name('page.about');
Route::get('/contact', 'FrontendController@contact')->name('page.contact');
Route::get('/property/{id}', 'FrontendController@showProperty')->name('show.property');
Route::get('/agent/{id}', 'FrontendController@getAgentDetails')->name('agent.details');

Route::get('/sell-your-property', 'FrontendController@getSellProperty')->name('page.property.sell');
Route::post('/sell-your-property', 'FrontendController@postSellProperty');

Route::get('/post-your-requirement', 'FrontendController@getBuyProperty')->name('page.property.buy');
Route::post('/post-your-requirement', 'FrontendController@postBuyProperty');

Route::get('/terms-and-conditions', 'FrontendController@getTermsAndConditions')->name('page.terms');
Route::get('/privacy-policy', 'FrontendController@getPrivacy')->name('page.privacy');

Auth::routes();

Route::group(['middleware' => 'auth'], function () {
    Route::get('/home', 'HomeController@index')->name('home');
    
    Route::group(['middleware' => 'admin'], function () {

        // states routes
        Route::resource('states', 'StatesController');
        Route::get('/state/active/{id}', 'StatesController@active')->name('state.active');
        Route::get('/state/inactive/{id}', 'StatesController@inactive')->name('state.inactive');

        // cities route
        Route::resource('cities', 'CitiesController');
        Route::get('/city/active/{id}', 'CitiesController@active')->name('city.active');
        Route::get('/city/inactive/{id}', 'CitiesController@inactive')->name('city.inactive');

        Route::resource('property-types', 'PropertyTypesController');
        Route::resource('bhk', 'BHKController');
        Route::resource('face', 'FaceController');
        Route::resource('venture', 'VentureController');
        Route::resource('office', 'OfficeController');
        Route::resource('builders', 'BuilderProfileController');

        Route::resource('agents', 'AgentProfileController');
        Route::get('/agents/premium/{id}/edit', 'AgentProfileController@editPremium')->name('agents.premium.make');
        Route::post('/agents/premium/{id}/edit', 'AgentProfileController@updatePremium');


        Route::resource('advertisement', 'AdvertisementController');
        Route::resource('properties', 'PropertiesController');
        Route::get('/property/request/delete', 'PropertiesController@getRequestDelete')->name('property.delete.request');
        Route::get('/property/premium/{property}', 'PropertiesController@premiumEdit')->name('property.premium.edit');
        Route::put('/property/premium/{property}', 'PropertiesController@premiumUpdate')->name('property.premium.update');
        Route::resource('landmark', 'LandmarkController');
        Route::resource('area', 'AreaController');
        Route::resource('price', 'PriceController');
        Route::resource('certificate', 'CertificatesController');
        Route::resource('requirement', 'RequirementsController');
        Route::get('/requirement/request/delete', 'RequirementsController@getDeleteRequests')->name('requirement.delete.request');
        Route::get('/premium-ad-requests', 'PremiumAdRequestsController@index')->name('premium.request.index');
        Route::get('/premium-ad-requests/edit/{id}', 'PremiumAdRequestsController@edit')->name('premium.request.edit');
        Route::patch('/premium-ad-requests/update/{id}', 'PremiumAdRequestsController@update')->name('premium.request.update');
        Route::delete('/premium-ad-requests/delete/{id}', 'PremiumAdRequestsController@delete')->name('premium.request.delete');
        Route::get('/finance', 'FinanceController@index')->name('finance.index');
        Route::resource('callers', 'CallerController');
    });
});
