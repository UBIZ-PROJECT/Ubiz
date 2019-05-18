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
        Route::redirect('/', '/events')->name('/');
        Route::get('login', ['as' => 'login', 'uses' => 'Web\UsersController@login']);
        Route::get('users', ['as' => 'users', 'uses' => 'Web\UsersController@index']);
        Route::get('suppliers', ['as'=>'supplier', 'uses'=>'Web\SupplierController@suppliers']);
        Route::get('customers', ['as' => 'customer', 'uses' => 'Web\CustomerController@customer']);
        Route::get('departments', ['as' => 'departments', 'uses' => 'Web\DepartmentsController@index']);
        Route::get('currency', ['as' => 'currency', 'uses' => 'Web\CurrencyController@index']);
        Route::get('products', ['as'=>'products', 'uses'=>'Web\AccessoryController@accessories']);
        Route::get('products/{brd_id}', ['as'=>'products', 'uses'=>'Web\ProductController@productByBrand'])->where('brd_id', '[0-9]+');
        Route::get('brands', ['as'=>'brands', 'uses'=>'Web\BrandController@brands']);
        Route::get('setting/currency', ['as' => 'currency', 'uses' => 'Web\CurrencyController@index']);
        Route::get('setting/company', ['as' => 'company', 'uses' => 'Web\CompanyController@index']);
        Route::get('setting/permission', ['as' => 'permission', 'uses' => 'Web\PermissionController@index']);
        Route::get('products', ['as'=>'supplier', 'uses'=>'Web\AccessoryController@accessories']);
        Route::get('pricing', ['as'=>'pricing', 'uses'=>'Web\PricingController@pricing']);
        Route::get('orders', ['as'=>'orders', 'uses'=>'Web\OrderController@index']);
        Route::get('orders/{ord_id}', ['as'=>'orders-detail', 'uses'=>'Web\OrderController@detail'])->where('ord_id', '[0-9]+');
        Route::get('quoteprices', ['as'=>'quoteprices', 'uses'=>'Web\QuotepriceController@index']);
        Route::get('quoteprices/{qp_id}', ['as'=>'quoteprices-detai', 'uses'=>'Web\QuotepriceController@detail'])->where('qp_id', '[0-9]+');
        Route::get('quoteprices/{qp_id}/pdf/{uniqid}', ['as'=>'quoteprices-pdf', 'uses'=>'Web\QuotepriceController@pdf'])->where('qp_id', '[0-9]+');
        Route::get('quoteprices/{cus_id}/create', ['as'=>'quoteprices-create', 'uses'=>'Web\QuotepriceController@create'])->where('cus_id', '[0-9]+');
        Route::get('events', ['as'=>'events', 'uses'=>'Web\EventController@index']);
    });
});
