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

        Route::get('users', ['as' => 'users-search', 'uses' => 'Api\UsersController@search']);
        Route::get('users/{id}', ['as' => 'user-detail', 'uses' => 'Api\UsersController@detail']);
        Route::post('users/{id}/update', ['as' => 'user-update', 'uses' => 'Api\UsersController@update']);
        Route::put('users', ['as' => 'insert-user', 'uses' => 'Api\UsersController@insert']);
        Route::delete('users/{ids}/delete', ['as' => 'delete-users', 'uses' => 'Api\UsersController@delete']);

        Route::post('myaccount/{id}/update', ['as' => 'myaccount-update', 'uses' => 'Api\MyAccountController@update']);
        Route::post('myaccount/{id}/passwd', ['as' => 'myaccount-update', 'uses' => 'Api\MyAccountController@passwd']);

        Route::get('departments', ['as' => 'departments-search', 'uses' => 'Api\DepartmentsController@search']);
        Route::get('departments/{id}', ['as' => 'department-detail', 'uses' => 'Api\DepartmentsController@detail']);
        Route::post('departments/{id}/update', ['as' => 'department-update', 'uses' => 'Api\DepartmentsController@update']);
        Route::put('departments', ['as' => 'department-insert', 'uses' => 'Api\DepartmentsController@insert']);
        Route::delete('departments/{ids}/delete', ['as' => 'departments-delete', 'uses' => 'Api\DepartmentsController@delete']);

        Route::get('suppliers', ['as' => 'api-suppliers', 'uses' => 'Api\SupplierController@search']);
        Route::post('suppliers/insert', ['as' => 'suppliers-insert', 'uses' => 'Api\SupplierController@insert']);
        Route::put('suppliers/{id}/update', ['as' => 'suppliers-update', 'uses' => 'Api\SupplierController@update']);
        Route::put('suppliers/{id}/updatePaging', ['as' => 'suppliers-update', 'uses' => 'Api\SupplierController@updateByPaging']);
        Route::delete('suppliers/{ids}/delete', ['as' => 'suppliers-delete', 'uses' => 'Api\SupplierController@delete']);
        Route::get('suppliers/{id}', ['as' => 'suppliers-detail', 'uses' => 'Api\SupplierController@detail']);

        Route::get('customers/generate-cus-code', ['as' => 'generate-cus-code', 'uses' => 'Api\CustomerController@generateCusCode']);
        Route::get('customers', ['as' => 'customers-search', 'uses' => 'Api\CustomerController@search']);
        Route::get('customers/{cus_id}', ['as' => 'customers-detail', 'uses' => 'Api\CustomerController@detail']);
        Route::put('customers', ['as' => 'customers-insert', 'uses' => 'Api\CustomerController@insert']);
        Route::post('customers/{cus_id}/update', ['as' => 'customers-update', 'uses' => 'Api\CustomerController@update']);
        Route::delete('customers/{cus_ids}/delete', ['as' => 'customers-delete', 'uses' => 'Api\CustomerController@delete']);

        Route::get('currency', ['as' => 'currency-search', 'uses' => 'Api\CurrencyController@search']);
        Route::get('currency/{id}', ['as' => 'currency-detail', 'uses' => 'Api\CurrencyController@detail']);
        Route::delete('currency/{ids}/delete', ['as' => 'currency-delete', 'uses' => 'Api\CurrencyController@delete']);
        Route::post('currency/{id}/update', ['as' => 'currency-update', 'uses' => 'Api\CurrencyController@update']);
        Route::put('currency', ['as' => 'currency-insert', 'uses' => 'Api\CurrencyController@insert']);

        Route::get('company', ['as' => 'company-search', 'uses' => 'Api\CompanyController@search']);
        Route::get('company/{id}', ['as' => 'company-detail', 'uses' => 'Api\CompanyController@detail']);
        Route::put('company', ['as' => 'company-insert', 'uses' => 'Api\CompanyController@insert']);
        Route::delete('company/{ids}/delete', ['as' => 'company-delete', 'uses' => 'Api\CompanyController@delete']);
        Route::post('company/{id}/update', ['as' => 'company-update', 'uses' => 'Api\CompanyController@update']);

        Route::get('products', ['as' => 'api-product', 'uses' => 'Api\ProductController@getProduct']);
        Route::get('products/detail', ['as' => 'api-product-detail', 'uses' => 'Api\ProductController@getEachProductPaging']);
        Route::post('products/insert', ['as' => 'product-insert', 'uses' => 'Api\ProductController@insertProduct']);
        Route::put('products/{id}/update', ['as' => 'product-update', 'uses' => 'Api\ProductController@updateProduct']);
        Route::put('products/{id}/updatePaging', ['as' => 'product-update', 'uses' => 'Api\ProductController@updateProductPaging']);
        Route::delete('products/{ids}/delete', ['as' => 'product-delete', 'uses' => 'Api\ProductController@deleteProduct']);

        Route::get('quoteprices', ['as' => 'quoteprices-search', 'uses' => 'Api\QuotepriceController@search']);
        Route::post('quoteprices/{cus_id}/create', ['as' => 'api-create-quoteprice', 'uses' => 'Api\QuotepriceController@create'])->where('cus_id', '[0-9]+');
        Route::post('quoteprices/{qp_id}/update', ['as' => 'api-update-quoteprice', 'uses' => 'Api\QuotepriceController@update'])->where('qp_id', '[0-9]+');
        Route::post('quoteprices/{qp_id}/send', ['as' => 'api-send-quoteprice', 'uses' => 'Api\QuotepriceController@send'])->where('qp_id', '[0-9]+');
        Route::post('quoteprices/{qp_id}/download', ['as' => 'api-download-quoteprice', 'uses' => 'Api\QuotepriceController@download'])->where('qp_id', '[0-9]+');
        Route::delete('quoteprices/{qp_ids}/delete', ['as' => 'api-delete-quoteprices', 'uses' => 'Api\QuotepriceController@delete'])->where('qp_ids', '^([0-9]+,)+[0-9]+|[0-9]+');
        Route::get('quoteprices/{qp_id}/history', ['as' => 'quoteprices-history', 'uses' => 'Api\QuotepriceHistoryController@search'])->where('qp_id', '[0-9]+');
        Route::get('quoteprices/{qp_id}/history/{his_qp_id}', ['as' => 'quoteprices-history-detai', 'uses' => 'Api\QuotepriceHistoryController@detail'])->where(['qp_id' => '[0-9]+', 'his_qp_id' => '[0-9]+']);

        Route::get('orders', ['as' => 'api-get-orders', 'uses' => 'Api\OrderController@search']);
        Route::post('orders/{qp_id}/create', ['as' => 'api-create-order', 'uses' => 'Api\OrderController@create'])->where('qp_id', '[0-9]+');
        Route::post('orders/{ord_id}/update', ['as' => 'api-update-order', 'uses' => 'Api\OrderController@update'])->where('ord_id', '[0-9]+');
        Route::post('orders/{ord_id}/delivery', ['as' => 'api-update-delivery', 'uses' => 'Api\OrderController@delivery'])->where('ord_id', '[0-9]+');
        Route::delete('orders/{ord_ids}/delete', ['as' => 'api-delete-orders', 'uses' => 'Api\OrderController@delete'])->where('ord_ids', '^([0-9]+,)+[0-9]+|[0-9]+');
        Route::get('orders/{ord_id}/history', ['as' => 'orders-history', 'uses' => 'Api\OrderHistoryController@search'])->where('ord_id', '[0-9]+');
        Route::get('orders/{ord_id}/history/{his_ord_id}', ['as' => 'orders-history-detail', 'uses' => 'Api\OrderHistoryController@detail'])->where(['ord_id' => '[0-9]+', 'his_ord_id' => '[0-9]+']);

        Route::post('permission', ['as' => 'set-permission', 'uses' => 'Api\PermissionController@setPermissions']);
        Route::get('permission/{dep_id}/{scr_id}', ['as' => 'get-dep-permission', 'uses' => 'Api\PermissionController@getDepPermissions']);
        Route::get('permission/{dep_id}/{scr_id}/{usr_id}', ['as' => 'get-usr-permission', 'uses' => 'Api\PermissionController@getUsrPermissions']);

        Route::get('brands', ['as' => 'api-brand', 'uses' => 'Api\BrandController@getBrand']);
        Route::get('brands/detail', ['as' => 'api-brand-detail', 'uses' => 'Api\BrandController@getEachBrandPaging']);
        Route::post('brands/insert', ['as' => 'brand-insert', 'uses' => 'Api\BrandController@insertBrand']);
        Route::post('brands/upload', ['as' => 'brand-upload-file', 'uses' => 'Api\BrandController@uploadFile']);
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
        Route::delete('keeper/{id}/delete', ['as' => 'api-keeper-delete', 'uses' => 'Api\KeeperController@deleteKeeper']);

        Route::get('events', ['as' => 'api-get-events', 'uses' => 'Api\EventController@getEvents']);
        Route::get('events/pic', ['as' => 'api-get-events', 'uses' => 'Api\EventController@getPic']);
        Route::get('events/export', ['as' => 'api-get-events', 'uses' => 'Api\EventController@exportEvent']);
        Route::get('events/{id}', ['as' => 'api-get-event', 'uses' => 'Api\EventController@getEvent']);
        Route::post('events', ['as' => 'api-insert-event', 'uses' => 'Api\EventController@insertEvent']);
        Route::post('events/{id}/update', ['as' => 'api-update-event', 'uses' => 'Api\EventController@updateEvent']);
        Route::delete('events/{id}/delete', ['as' => 'api-delete-event', 'uses' => 'Api\EventController@deleteEvent'])->where('id', '[0-9]+');;

        Route::get('report/{type}', ['as' => 'api-get-report', 'uses' => 'Api\ReportController@getReport']);
        Route::get('report', ['as' => 'api-get-report', 'uses' => 'Api\ReportController@getReport']);
        Route::post('report/export-rep', ['as'=>'export-rep', 'uses'=>'Api\ReportController@exportRep']);
        Route::post('report/import-rep', ['as'=>'import-rep', 'uses'=>'Api\ReportController@importRep']);

        Route::get('drive/{uniqid}', ['as' => 'api-get-drives', 'uses' => 'Api\DriveController@getFiles']);
        Route::get('drive/{uniqid}/detail', ['as' => 'api-get-detail', 'uses' => 'Api\DriveController@getDetail']);
        Route::get('drive/{uniqid}/children', ['as' => 'api-get-children', 'uses' => 'Api\DriveController@getChildren']);
        Route::get('drive/{uniqid}/sibling', ['as' => 'api-get-sibling', 'uses' => 'Api\DriveController@getSibling']);
        Route::post('drive/{uniqid}/upload', ['as' => 'api-upload-drives', 'uses' => 'Api\DriveController@uploadFiles']);
        Route::delete('drive/{uniqid}/delete', ['as' => 'api-delete-drives', 'uses' => 'Api\DriveController@deleteFiles']);
        Route::get('drive/{uniqid}/download', ['as' => 'api-download-drives', 'uses' => 'Api\DriveController@downloadFiles']);
        Route::post('drive/{uniqid}/add-new-folder', ['as' => 'api-add-new-folder', 'uses' => 'Api\DriveController@addNewFolder']);
        Route::post('drive/{uniqid}/change-name', ['as' => 'api-change-name', 'uses' => 'Api\DriveController@changeName']);
        Route::post('drive/{uniqid}/change-color', ['as' => 'api-change-color', 'uses' => 'Api\DriveController@changeColor']);
        Route::post('drive/{uniqid}/do-copy', ['as' => 'api-copy', 'uses' => 'Api\DriveController@doCopy']);
        Route::post('drive/{uniqid}/move-to', ['as' => 'api-move-to', 'uses' => 'Api\DriveController@moveTo']);

        Route::get('contracts', ['as' => 'api-get-contracts', 'uses' => 'Api\ContractController@search']);
        Route::post('contracts/{ctr_id}/create', ['as' => 'api-create-contract', 'uses' => 'Api\ContractController@create'])->where('ctr_id', '[0-9]+');
        Route::post('contracts/{ctr_id}/update', ['as' => 'api-update-contract', 'uses' => 'Api\ContractController@update'])->where('ctr_id', '[0-9]+');
        Route::delete('contracts/{ctr_ids}/delete', ['as' => 'api-delete-contracts', 'uses' => 'Api\ContractController@delete'])->where('ctr_ids', '^([0-9]+,)+[0-9]+|[0-9]+');

    });
});
