<?php

use Illuminate\Http\Request;

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
//
Route::prefix("/v1")->middleware(['api', 'cors'])->group(function () {
    Route::post('login', 'Api\AuthController@login');
    Route::middleware(['jwt'])->group(function () {
        Route::get('logout', ['as' => 'api-logout', 'uses' => 'Api\AuthController@logout']);

        Route::get('users', ['as' => 'get-users', 'uses' => 'Api\UsersController@getUsers']);
        Route::get('users/{id}', ['as' => 'get-user', 'uses' => 'Api\UsersController@getUser']);
        Route::post('users/{id}/update', ['as' => 'update-user', 'uses' => 'Api\UsersController@updateUser']);
        Route::put('users', ['as' => 'insert-user', 'uses' => 'Api\UsersController@insertUser']);
        Route::delete('users/{ids}/delete', ['as' => 'delete-users', 'uses' => 'Api\UsersController@deleteUsers']);

        Route::get('suppliers', ['as' => 'api-suppliers', 'uses' => 'Api\SupplierController@getSuppliers']);
        Route::post('suppliers/insert', ['as' => 'suppliers-insert', 'uses' => 'Api\SupplierController@insertSupplier']);
        Route::put('suppliers/{id}/update', ['as' => 'suppliers-update', 'uses' => 'Api\SupplierController@updateSupplierById']);
        Route::delete('suppliers/{ids}/delete', ['as' => 'suppliers-delete', 'uses' => 'Api\SupplierController@deleteSuppliersById']);
        Route::get('suppliers/{id}', ['as'=> 'suppliers-detail','uses'=> 'Api\SupplierController@getSupplierById']);

        Route::get('customer', ['as' => 'api-customer', 'uses' => 'Api\CustomerController@getCustomers']);
        Route::get('customer/{id}', ['as'=> 'delete-customer','uses'=> 'Api\CustomerController@deleteCustomer']);

        Route::get('currency', ['as' => 'api-currency', 'uses' => 'Api\CurrencyController@getCurrency']);
        Route::delete('currency/{id}', ['as'=> 'delete-currency','uses'=> 'Api\CurrencyController@deleteCurrency']);
        Route::get('customers', ['as' => 'api-customer', 'uses' => 'Api\CustomerController@getCustomers']);
        Route::get('customer-edit', ['as'=> 'get-customer','uses'=> 'Api\CustomerController@getCustomer']);
        Route::post('customer-create', ['as'=> 'insert-customer','uses'=> 'Api\CustomerController@insertCustomer']);
        Route::post('customer-update', ['as'=> 'update-customer','uses'=> 'Api\CustomerController@updateCustomer']);
        Route::delete('customers/{ids}', ['as'=> 'delete-customer','uses'=> 'Api\CustomerController@deleteCustomer']);
    });
});