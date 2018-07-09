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
    Route::post('auth/login', 'Api\AuthController@login');
    Route::post('auth/register', 'Api\AuthController@register');
    Route::middleware(['jwt'])->group(function () {
        Route::get('auth/logout', 'Api\AuthController@logout');
        Route::get('users', ['as' => 'api-users', 'uses' => 'Api\UsersController@getUsers']);
        Route::delete('users/{ids}', ['as' => 'delete-users', 'uses' => 'Api\UsersController@deleteUsers']);
        Route::get('suppliers', ['as' => 'api-suppliers', 'uses' => 'Api\SupplierController@getSuppliers']);
        Route::get('suppliers/{id}', ['as'=> 'api-suppliers','uses'=> 'Api\SupplierController@getSupplierById']);
    });
});