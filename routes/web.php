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

Route::get('/reserve_account', 'monnifyClientController@reserveAccount')->name('reserve_account');

Route::get('/deactivate_account', 'monnifyClientController@deactivateAccount')->name('deactivate_account');


Route::get('/transaction_status', 'monnifyClientController@transactionStatus')->name('transaction_status');
