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
        Route::get('users', ['as' => 'api-users', 'uses' => 'Api\UsersController@getUsers']);
        Route::delete('users/{ids}/delte', ['as' => 'delete-users', 'uses' => 'Api\UsersController@deleteUsers']);
        Route::get('suppliers', ['as' => 'api-suppliers', 'uses' => 'Api\SupplierController@getSuppliers']);
        Route::post('suppliers/insert', ['as' => 'suppliers-insert', 'uses' => 'Api\SupplierController@insertSupplier']);
        Route::put('suppliers/{id}/update', ['as' => 'suppliers-update', 'uses' => 'Api\SupplierController@updateSupplierById']);
        Route::delete('suppliers/{ids}/delete', ['as' => 'suppliers-delete', 'uses' => 'Api\SupplierController@deleteSuppliersById']);
        Route::get('suppliers/{id}', ['as'=> 'suppliers-detail','uses'=> 'Api\SupplierController@getSupplierById']);
		Route::get('customer', ['as' => 'api-customer', 'uses' => 'Api\CustomerController@getCustomers']);
		Route::get('customer/{id}', ['as'=> 'delete-customer','uses'=> 'Api\CustomerController@deleteCustomer']);
    });
});