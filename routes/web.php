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

Route::get('/', 'MainController@index')->name('');
Route::get('/logout', 'Auth\LoginController@logout');

Auth::routes([ 'verify' => true ]);

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/channels', 'ChannelController@index');

Route::group(['prefix' => 'channels'], function () {
    Route::get('/messages', 'MessageController@showMessages');
    Route::post('/messages', 'MessageController@storeMessage');
});

Route::get('/oauth/{service}', 'Auth\LoginController@oauth');
Route::get('/callback/{service}', 'Auth\LoginController@callback');

Route::post('/user/update', 'UserController@update');
Route::get('/user/get', 'UserController@getuser');

Route::get('/dashboard{any?}', 'DashboardController@index')->where('any', '.*')->name('dashboard');


//Route::get('/{any}', 'DashboardController@index');
