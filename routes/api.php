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

        Route::get('customers/generate-cus-code', ['as' => 'generate-cus-code', 'uses' => 'Api\CustomerController@generateCusCode']);
        Route::get('customers', ['as' => 'get-customers', 'uses' => 'Api\CustomerController@getCustomers']);
        Route::get('customers/{cus_id}', ['as' => 'get-customer', 'uses' => 'Api\CustomerController@getCustomer']);
        Route::put('customers', ['as' => 'insert-customer', 'uses' => 'Api\CustomerController@insertCustomer']);
        Route::post('customers/{cus_id}/update', ['as' => 'update-currency', 'uses' => 'Api\CustomerController@updateCustomer']);
        Route::delete('customers/{cus_ids}/delete', ['as' => 'delete-currency', 'uses' => 'Api\CustomerController@deleteCustomer']);

        Route::get('currency', ['as' => 'get-currency', 'uses' => 'Api\CurrencyController@getCurrency']);
        Route::get('currencies', ['as' => 'get-all-currency', 'uses' => 'Api\CurrencyController@getAllCurrency']);
        Route::get('currency/{id}', ['as' => 'get-currency', 'uses' => 'Api\CurrencyController@getCurrencyById']);
        Route::delete('currency/{ids}/delete', ['as' => 'delete-currency', 'uses' => 'Api\CurrencyController@deleteCurrency']);
        Route::post('currency/{id}/update', ['as' => 'update-currency', 'uses' => 'Api\CurrencyController@updatedCurrency']);
        Route::put('currency', ['as' => 'insert-currency', 'uses' => 'Api\CurrencyController@insertCurrency']);

        Route::get('company', ['as' => 'get-company', 'uses' => 'Api\CompanyController@getCompany']);
        Route::get('companies', ['as' => 'get-all-company', 'uses' => 'Api\CompanyController@getAllCompany']);
        Route::get('company/{id}', ['as' => 'get-company', 'uses' => 'Api\CompanyController@getCompanyById']);
        Route::delete('company/{ids}/delete', ['as' => 'delete-company', 'uses' => 'Api\CompanyController@deleteCompany']);
        Route::post('company/{id}/update', ['as' => 'update-company', 'uses' => 'Api\CompanyController@updatedCompany']);
        Route::put('company', ['as' => 'insert-company', 'uses' => 'Api\CompanyController@insertCompany']);

        Route::get('products', ['as' => 'api-product', 'uses' => 'Api\ProductController@getProduct']);
        Route::get('products/detail', ['as' => 'api-product-detail', 'uses' => 'Api\ProductController@getEachProductPaging']);
        Route::post('products/insert', ['as' => 'product-insert', 'uses' => 'Api\ProductController@insertProduct']);
        Route::put('products/{id}/update', ['as' => 'product-update', 'uses' => 'Api\ProductController@updateProduct']);
        Route::put('products/{id}/updatePaging', ['as' => 'product-update', 'uses' => 'Api\ProductController@updateProductPaging']);
        Route::delete('products/{ids}/delete', ['as' => 'product-delete', 'uses' => 'Api\ProductController@deleteProduct']);

        Route::get('quoteprices', ['as' => 'api-get-quoteprices', 'uses' => 'Api\QuotepriceController@getQuoteprices']);
        Route::post('quoteprices/{cus_id}/create', ['as' => 'api-create-quoteprice', 'uses' => 'Api\QuotepriceController@createQuoteprice'])->where('cus_id', '[0-9]+');
        Route::post('quoteprices/{qp_id}/update', ['as' => 'api-update-quoteprice', 'uses' => 'Api\QuotepriceController@updateQuoteprice'])->where('qp_id', '[0-9]+');
        Route::post('quoteprices/{qp_id}/send', ['as' => 'api-send-quoteprice', 'uses' => 'Api\QuotepriceController@sendQuoteprice'])->where('qp_id', '[0-9]+');
        Route::post('quoteprices/{qp_id}/download', ['as' => 'api-download-quoteprice', 'uses' => 'Api\QuotepriceController@downloadQuoteprice'])->where('qp_id', '[0-9]+');
        Route::delete('quoteprices/{qp_ids}/delete', ['as' => 'api-delete-quoteprices', 'uses' => 'Api\QuotepriceController@deleteQuoteprices'])->where('qp_ids', '^([0-9]+,)+[0-9]+|[0-9]+');
        Route::get('quoteprices/{qp_id}/history', ['as' => 'quoteprices-history', 'uses' => 'Api\QuotepriceHistoryController@getQuoteprices'])->where('qp_id', '[0-9]+');
        Route::get('quoteprices/{qp_id}/history/{his_qp_id}', ['as' => 'quoteprices-history-detai', 'uses' => 'Api\QuotepriceHistoryController@detail'])->where(['qp_id' => '[0-9]+', 'his_qp_id' => '[0-9]+']);

        Route::get('orders', ['as' => 'api-get-orders', 'uses' => 'Api\OrderController@getOrders']);
        Route::post('orders/{qp_id}/create', ['as' => 'api-create-order', 'uses' => 'Api\OrderController@createOrder'])->where('qp_id', '[0-9]+');
        Route::post('orders/{ord_id}/update', ['as' => 'api-update-order', 'uses' => 'Api\OrderController@updateOrder'])->where('ord_id', '[0-9]+');
        Route::post('orders/{ord_id}/salestep', ['as' => 'api-update-salestep', 'uses' => 'Api\OrderController@updateSaleStep'])->where('ord_id', '[0-9]+');
        Route::delete('orders/{ord_ids}/delete', ['as' => 'api-delete-orders', 'uses' => 'Api\OrderController@deleteOrders'])->where('ord_ids', '^([0-9]+,)+[0-9]+|[0-9]+');
        Route::get('orders/{ord_id}/history', ['as' => 'orders-history', 'uses' => 'Api\OrderHistoryController@getOrders'])->where('ord_id', '[0-9]+');
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

        Route::get('drive', ['as' => 'api-get-drives', 'uses' => 'Api\DriveController@getData']);
        Route::get('drive/{uniqid}', ['as' => 'api-get-report', 'uses' => 'Api\DriveController@getData']);
    });
});
