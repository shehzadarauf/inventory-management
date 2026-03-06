<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;

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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::group(['namespace'=>'App\Http\Controllers\Api'], function () {
    
    Route::any('forget/password','Admin\AuthController@forgetPassword');
    Route::any('reset/password','Admin\AuthController@resetPassword');
    Route::group(['namespace'=>'Admin', 'prefix' => 'admin'], function () {
        Route::group(['middleware' => 'auth:api',], function () {
            
            Route::any('get/users/bytype','UserController@getUserByType');
            Route::any('edit/user','UserController@editUser');
            Route::any('update/user','UserController@updateUser');
            Route::any('delete/user','UserController@deleteUser');
            Route::any('get/dashboard/data','UserController@getDataForDashbard');
        });
     
    });
    Route::group(['namespace'=>'User'], function () {
        Route::group(['middleware' => 'auth:api',], function () {
            //////////// Category Routes //////////////////
            Route::any('add/category','CategoryController@addCategory');
            Route::any('update/category','CategoryController@updateCategory');
            Route::any('delete/category','CategoryController@deleteCategory');
            Route::any('all/categories','CategoryController@allCategories');
            ///////////////// Product Routes ////////////////
            Route::any('add/product','ProductController@addProduct');
            Route::any('update/product','ProductController@updateProduct');
            Route::any('delete/product','ProductController@deleteProduct');
            Route::any('all/products','ProductController@allProducts');
            Route::any('categoryProducts','ProductController@getCategotryProducts');
            Route::any('get/size/length','ProductController@getSizeLength');
            Route::any('get/size/length/weighment','ProductController@getSizeLengthWeighment');

            ///////////////// Product Size Routes ////////////
            Route::any('add/size','ProductSizeController@addProductSize');
            Route::any('delete/size','ProductSizeController@deleteProductSize');
            Route::any('all/sizes','ProductSizeController@allProductSizes');
            ///////////////// Product Lenth Routes ///////////
            Route::any('add/length','ProductLengthController@addProductLength');
            Route::any('delete/length','ProductLengthController@deleteProductLength');
            Route::any('all/lengths','ProductLengthController@allProductLengths');
            //////////////// Inventory Routes ////////////////
            Route::any('add/inventory','InventoryController@addInventory');
            Route::any('view/inventory','InventoryController@viewInventory');
            Route::any('update/inventory','InventoryController@updateInventory');
            Route::any('tamestamp/inventory','InventoryController@inventoryByDate');
            Route::any('load/inventory','InventoryController@inventoryByLoads');
            Route::any('delete/loads','InventoryController@deleteLoads');
            Route::any('inventory/thirty/days','InventoryController@thirtyDaysInventory');
            // Route::any('get/inventory/timestamp','InventoryController@getInventoryByTimestamp');
            ///////////////// Customer Routes ////////////////
            Route::any('add/customer','CustomerController@addCustomer');
            Route::any('get/customers','CustomerController@getCustomers');
            Route::any('get/walkin/customers','CustomerController@getWalkInCustomers');
            Route::any('edit/customer','CustomerController@editCustomer');
            Route::any('update/customer','CustomerController@updateCustomer');
            Route::any('delete/customer','CustomerController@deleteCustomer');
            Route::any('search/customer','CustomerController@searchCustomer');
            Route::any('update/firebase_token','UserController@updateFirebaseToken');

            ///////////////// Leads Routes /////////////////////
            Route::any('add/lead','LeadController@addLead');
            Route::any('get/leads','LeadController@getLeads');
            Route::any('edit/lead','LeadController@editLead');
            Route::any('update/lead','LeadController@updateLead');
            Route::any('delete/lead','LeadController@deleteLead');
            Route::any('make/lead/customer','LeadController@makeLeadToCustomer');

            ///////////////// Sale Route /////////////////////
            Route::any('sale/create','SaleController@createSale');
            Route::any('view/sales','SaleController@viewSales');
            Route::any('send/notification','SaleController@sendNotification');
            Route::any('view/sale/detail','SaleController@viewSaleDetail');
            Route::any('update/sale','SaleController@updateSale');
            Route::any('delete/sale','SaleController@deleteSale');
            Route::any('all/sales','SaleController@allSales');
            Route::any('sales/byDate','SaleController@saleByDate');

            Route::any('thirty/days/sales','SaleController@lastThirtyDaysSales');

            /////////////////  Sale Return Routes ////////////////
            Route::any('all/sale/returns','SaleReturnController@allSalesReturns');
            Route::any('add/sale/return','SaleReturnController@returnSale');
            Route::any('view/sale/returns','SaleReturnController@viewSaleReturns');
            Route::any('view/return/detail','SaleReturnController@viewSaleReturnDetail');


            ///////////////// Notification Routes ////////////////
            Route::any('view/notifications','NotificationController@viewNotifications');
            Route::any('notification/detail','NotificationController@notificationDetail');

            //////////////// Weighment Unit Routes //////////////////
            Route::any('weighmentunit/store','WeighmentUnitController@weighmentUnitStore');
            Route::any('weighmentunits/all','WeighmentUnitController@weignmentUnits');
            Route::any('weighmentunit/update','WeighmentUnitController@weighmentUpdate');
            Route::any('weighmentunit/delete','WeighmentUnitController@weighmentDelete');
            Route::any('set/unit/default','WeighmentUnitController@setUnitDefault');

            /////////////// Weighment Routes   //////////////////////
            Route::any('add/weighment','WeighmentController@store');
            Route::any('view/weighment','WeighmentController@viewWeighment');
            Route::any('update/weighment','WeighmentController@updateWeighment');
        });
      
    });
    Route::group(['namespace'=>'User', 'prefix' => 'user'], function () {
        Route::any('login', function (Request $request) {
            Log::info('[ROUTE] Login request diagnostic', [
                'email_magic'        => $request->email,
                'email_input'        => $request->input('email'),
                'all_parsed'         => $request->all(),
                'raw_body'           => $request->getContent(),
                'content_type'       => $request->header('Content-Type'),
                'accept'             => $request->header('Accept'),
                'ip'                 => $request->ip(),
                'method'             => $request->method(),
                'user_agent'         => $request->userAgent(),
                'is_json'            => $request->isJson(),
                'timestamp'          => now()->toDateTimeString(),
            ]);
            return app()->call('App\Http\Controllers\Api\User\AuthController@login', ['request' => $request]);
        });
        Route::any('register','UserController@register');
        Route::group(['middleware' => 'auth:user',], function () {

        });
    });
});
