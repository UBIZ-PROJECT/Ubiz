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

Route::middleware(['api', 'cors'])->group(function () {
    Route::middleware(['jwt'])->group(function () {
        Route::get('login', ['as' => 'login', 'uses' => 'Web\HomeController@login']);
        Route::get('/', ['as' => '/', 'uses' => 'Web\HomeController@home']);
        Route::get('users', ['as' => 'users', 'uses' => 'Web\UsersController@index']);
        Route::get('suppliers', ['as'=>'supplier', 'uses'=>'Web\SupplierController@suppliers']);
        Route::get('customer', ['as' => 'customer', 'uses' => 'Web\CustomerController@customer']);
    });
});
