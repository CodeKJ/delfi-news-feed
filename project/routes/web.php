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

Route::get('/', 'DelfiController@index')->name('index');

Route::get('facebook/redirect', 'FacebookController@redirect')->name('facebook-login');
Route::get('facebook/callback', 'FacebookController@callback')->name('facebook-callback');

Route::get('profile', 'UserController@profile')->name('profile');
Route::post('profile', 'UserController@update')->name('profile-update');

Auth::routes();
