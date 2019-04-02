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

Route::get('/', function () {
    return view('welcome');
});

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
    });
});
