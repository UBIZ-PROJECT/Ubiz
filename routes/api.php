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

        Route::get('departments', ['as' => 'get-departments', 'uses' => 'Api\DepartmentsController@getDepartments']);
        Route::get('departments/{id}', ['as' => 'get-department', 'uses' => 'Api\DepartmentsController@getDepartment']);
        Route::post('departments/{id}/update', ['as' => 'update-department', 'uses' => 'Api\DepartmentsController@updateDepartment']);
        Route::put('departments', ['as' => 'insert-department', 'uses' => 'Api\DepartmentsController@insertDepartment']);
        Route::delete('departments/{ids}/delete', ['as' => 'delete-departments', 'uses' => 'Api\DepartmentsController@deleteDepartments']);

        Route::get('suppliers', ['as' => 'api-suppliers', 'uses' => 'Api\SupplierController@getSuppliers']);
        Route::post('suppliers/insert', ['as' => 'suppliers-insert', 'uses' => 'Api\SupplierController@insertSupplier']);
        Route::put('suppliers/{id}/update', ['as' => 'suppliers-update', 'uses' => 'Api\SupplierController@updateSupplierById']);
        Route::put('suppliers/{id}/updatePaging', ['as' => 'suppliers-update', 'uses' => 'Api\SupplierController@updateSupplierByPaging']);
        Route::delete('suppliers/{ids}/delete', ['as' => 'suppliers-delete', 'uses' => 'Api\SupplierController@deleteSuppliersById']);
        Route::get('suppliers/{id}', ['as' => 'suppliers-detail', 'uses' => 'Api\SupplierController@getSupplierById']);

        Route::get('customer', ['as' => 'api-customer', 'uses' => 'Api\CustomerController@getCustomers']);
        Route::get('customer/{id}', ['as' => 'delete-customer', 'uses' => 'Api\CustomerController@deleteCustomer']);
        Route::get('customers', ['as' => 'api-customer', 'uses' => 'Api\CustomerController@getCustomers']);
        Route::get('customer-edit', ['as' => 'get-customer', 'uses' => 'Api\CustomerController@getCustomer']);
        Route::post('customer-create', ['as' => 'insert-customer', 'uses' => 'Api\CustomerController@insertCustomer']);
        Route::post('customer-update', ['as' => 'update-customer', 'uses' => 'Api\CustomerController@updateCustomer']);
        Route::delete('customers/{ids}/delete', ['as' => 'delete-customer', 'uses' => 'Api\CustomerController@deleteCustomer']);

        Route::get('currency', ['as' => 'get-currency', 'uses' => 'Api\CurrencyController@getCurrency']);
        Route::get('currencies', ['as' => 'get-all-currency', 'uses' => 'Api\CurrencyController@getAllCurrency']);
        Route::get('currency/{id}', ['as' => 'get-currency', 'uses' => 'Api\CurrencyController@getCurrencyById']);
        Route::delete('currency/{ids}/delete', ['as' => 'delete-currency', 'uses' => 'Api\CurrencyController@deleteCurrency']);
        Route::post('currency/{id}/update', ['as' => 'update-currency', 'uses' => 'Api\CurrencyController@updatedCurrency']);
        Route::put('currency', ['as' => 'insert-currency', 'uses' => 'Api\CurrencyController@insertCurrency']);

        Route::get('products', ['as' => 'api-product', 'uses' => 'Api\ProductController@getProduct']);
        Route::get('products/detail', ['as' => 'api-product-detail', 'uses' => 'Api\ProductController@getEachProductPaging']);
        Route::post('products/insert', ['as' => 'product-insert', 'uses' => 'Api\ProductController@insertProduct']);
        Route::put('products/{id}/update', ['as' => 'product-update', 'uses' => 'Api\ProductController@updateProduct']);
        Route::put('products/{id}/updatePaging', ['as' => 'product-update', 'uses' => 'Api\ProductController@updateProductPaging']);
        Route::delete('products/{ids}/delete', ['as' => 'product-delete', 'uses' => 'Api\ProductController@deleteProduct']);

        Route::get('brands', ['as' => 'api-brand', 'uses' => 'Api\BrandController@getBrand']);
        Route::get('brands/detail', ['as' => 'api-brand-detail', 'uses' => 'Api\BrandController@getEachBrandPaging']);
        Route::post('brands/insert', ['as' => 'brand-insert', 'uses' => 'Api\BrandController@insertBrand']);
        Route::put('brands/{id}/update', ['as' => 'brand-update', 'uses' => 'Api\BrandController@updateBrand']);
        Route::put('brands/{id}/updatePaging', ['as' => 'brand-update', 'uses' => 'Api\BrandController@updateBrandPaging']);
        Route::delete('brands/{ids}/delete', ['as' => 'brand-delete', 'uses' => 'Api\BrandController@deleteBrand']);

        Route::get('series', ['as' => 'api-series', 'uses' => 'Api\SeriesController@getSeries']);
        Route::post('series/insert', ['as' => 'api-series-insert', 'uses' => 'Api\SeriesController@insertSeries']);
        Route::put('series/{id}/update', ['as' => 'api-series-update', 'uses' => 'Api\SeriesController@updateSeries']);
        Route::delete('series/{ids}/delete', ['as' => 'api-series-delete', 'uses' => 'Api\SeriesController@deleteSeries']);

        Route::get('accessories', ['as' => 'api-accessory', 'uses' => 'Api\AccessoryController@getAccessory']);
        Route::get('accessories/detail', ['as' => 'api-accessory-detail', 'uses' => 'Api\AccessoryController@getEachAccessoryPaging']);
        Route::post('accessories/insert', ['as' => 'accessory-insert', 'uses' => 'Api\AccessoryController@insertAccessory']);
        Route::put('accessories/{id}/update', ['as' => 'accessory-update', 'uses' => 'Api\AccessoryController@updateAccessory']);
        Route::put('accessories/{id}/updatePaging', ['as' => 'accessory-update', 'uses' => 'Api\AccessoryController@updateAccessoryPaging']);
        Route::delete('accessories/{ids}/delete', ['as' => 'accessory-delete', 'uses' => 'Api\AccessoryController@deleteAccessory']);

        Route::get('keeper', ['as' => 'api-keeper', 'uses' => 'Api\KeeperController@getKeeper']);
        Route::post('keeper/insert', ['as' => 'api-keeper-insert', 'uses' => 'Api\KeeperController@insertKeeper']);
        Route::put('keeper/{id}/update', ['as' => 'api-keeper-update', 'uses' => 'Api\KeeperController@updateKeeper']);
        Route::delete('keeper/{ids}/delete', ['as' => 'api-keeper-delete', 'uses' => 'Api\KeeperController@deleteKeeper']);
    });
});