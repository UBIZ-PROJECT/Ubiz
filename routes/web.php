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
        Route::get('suppliers', ['as' => 'supplier', 'uses' => 'Web\SupplierController@suppliers']);
        Route::get('customers', ['as' => 'customer', 'uses' => 'Web\CustomerController@index']);
        Route::get('products', ['as' => 'products', 'uses' => 'Web\AccessoryController@accessories']);
        Route::get('products/{brd_id}', ['as' => 'products', 'uses' => 'Web\ProductController@productByBrand'])->where('brd_id', '[0-9]+');
        Route::get('brands', ['as' => 'brands', 'uses' => 'Web\BrandController@brands']);
        Route::get('setting/users', ['as' => 'users', 'uses' => 'Web\UsersController@index']);
        Route::get('setting/currency', ['as' => 'currency', 'uses' => 'Web\CurrencyController@index']);
        Route::get('setting/company', ['as' => 'company', 'uses' => 'Web\CompanyController@index']);
        Route::get('setting/departments', ['as' => 'company', 'uses' => 'Web\DepartmentsController@index']);
        Route::get('setting/permission', ['as' => 'permission', 'uses' => 'Web\PermissionController@index']);
        Route::get('products', ['as' => 'supplier', 'uses' => 'Web\AccessoryController@accessories']);
        Route::get('orders', ['as' => 'orders', 'uses' => 'Web\OrderController@index']);
        Route::get('orders/{ord_id}', ['as' => 'orders-detail', 'uses' => 'Web\OrderController@detail'])->where('ord_id', '[0-9]+');
        Route::get('quoteprices', ['as' => 'quoteprices', 'uses' => 'Web\QuotepriceController@index']);
        Route::get('quoteprices/{qp_id}', ['as' => 'quoteprices-detai', 'uses' => 'Web\QuotepriceController@detail'])->where('qp_id', '[0-9]+');
        Route::get('quoteprices/{qp_id}/preview', ['as' => 'quoteprices-pdf', 'uses' => 'Web\QuotepriceController@preview'])->where('qp_id', '[0-9]+');
        Route::get('quoteprices/{qp_id}/download/{uniqid}/{file_name}', ['as' => 'quoteprices-pdf', 'uses' => 'Web\QuotepriceController@download'])->where('qp_id', '[0-9]+');
        Route::get('quoteprices/{cus_id}/create', ['as' => 'quoteprices-create', 'uses' => 'Web\QuotepriceController@create'])->where('cus_id', '[0-9]+');
        Route::get('events', ['as' => 'events', 'uses' => 'Web\EventController@index']);
        Route::get('events/{id}', ['as' => 'event-detail', 'uses' => 'Web\EventController@detail'])->where('id', '[0-9]+');
        Route::get('events/download/{uniqid}/{file_name}', ['as' => 'event-export', 'uses' => 'Web\EventController@downloadEvent']);

        Route::get('orders/{ord_id}/history', ['as' => 'orders-history', 'uses' => 'Web\OrderHistoryController@index'])->where('ord_id', '[0-9]+');
        Route::get('orders/{ord_id}/history/{his_ord_id}', ['as' => 'orders-history-detail', 'uses' => 'Web\OrderHistoryController@detail'])->where(['ord_id' => '[0-9]+', 'his_ord_id' => '[0-9]+']);
        Route::get('quoteprices/{qp_id}/history', ['as' => 'quoteprices-history', 'uses' => 'Web\QuotepriceHistoryController@index'])->where('qp_id', '[0-9]+');
        Route::get('quoteprices/{qp_id}/history/{his_qp_id}', ['as' => 'quoteprices-history-detai', 'uses' => 'Web\QuotepriceHistoryController@detail'])->where(['qp_id' => '[0-9]+', 'his_qp_id' => '[0-9]+']);

        Route::get('report', ['as'=>'report', 'uses'=>'Web\ReportController@index']);
        Route::get('report/{type}', ['as'=>'report_with_type', 'uses'=>'Web\ReportController@index']);
        Route::get('report/{type}/export', ['as'=>'export', 'uses'=>'Web\ReportController@exportExcel']);

        Route::get('drive', ['as' => 'api-get-drives', 'uses' => 'Web\DriveController@index']);
        Route::get('drive/{uniqid}', ['as' => 'api-get-report', 'uses' => 'Web\DriveController@index']);

        Route::get('contracts', ['as' => 'contract', 'uses'=> 'Web\ContractController@contracts']);
        Route::get('contracts/{ctr_id}', ['as' => 'contract-detail', 'uses'=> 'Web\ContractController@detail']);
        Route::get('contracts/{ctr_id}/{type}/export', ['as' => 'export-contract', 'uses' => 'Web\ContractController@exportContract'])->where('ord_id', '[0-9]+');
    });
});
