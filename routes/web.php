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

Route::any('/auth', [
    'as' => 'auth', 'uses' => 'AuthController@authenticate'
]);

Route::get('/bills', [
    'as' => 'bills', 'uses' => 'BillController@getBillByUserLogin'
]);

Route::get('/cards', [
    'as' => 'cards', 'uses' => 'CardController@getCardLists'
]);

Route::get('/cardDetail', [
    'as' => 'cardDetail', 'uses' => 'CardController@getCard'
]);
