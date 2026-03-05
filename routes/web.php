<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('admin.auth.login');
});



Route::group(['namespace'=>'App\Http\Controllers'],function(){
    Route::group(['prefix'=>'admin','namespace'=>'Admin','as'=>'admin.'],function(){
        Route::view('login','admin.auth.login')->name('login');
        Route::post('login','AuthController@login')->name('login');
        Route::view('forget/password','admin.auth.password_forget')->name('forget_password');
        Route::post('forget/password','AuthController@forgetPassword')->name('forget.password');
        Route::view('reset/password','admin.auth.password_reset')->name('reset_password');
        Route::post('reset/password','AuthController@resetPassword')->name('reset.password');
       
        Route::group(['middleware'=>'auth'],function(){
            Route::get('logout','AuthController@logout')->name('logout');
            Route::get('dashboard','AdminDashboardController@dashboard')->name('dashboard');

            Route::resource('customer','CustomerController');
            Route::get('import-file', 'CustomerController@importCustomers')->name('import-customers');
            Route::post('import', 'CustomerController@storeCustomers')->name('import');

            Route::resource('user','UserController');
            Route::view('add-inventory','admin.inventory.create')->name('inventory');
            Route::post('add/inventory','InventoryController@addInventory')->name('add.inventory');
            Route::view('inventory/show','admin.inventory.show')->name('show.inventory');
            Route::view('inventory/edit','admin.inventory.edit')->name('edit.inventory');

            Route::post('product/get','AjaxController@getProduct')->name('product.get');

            ///////////// Ajax Call //////////////////////////
            Route::post('category/products', 'AjaxController@getProductsByCategory')->name('category.products');
            Route::post('product/inventory','AjaxController@prodcutInventories')->name('product.inventory.get');
            Route::post('inventory/timestamp','AjaxController@inventoryByDate')->name('product.inventorybytimestamp.get');

            ////////////// Category Routes ////////////////////////////
            Route::resource('category','CategoryController');
            /////////////// Product Routes ////////////////////////
            Route::resource('product','ProductController');
            Route::get('product/{product}/sizes','ProductController@sizes')->name('product.sizes');
            Route::get('product/{product}/lengths','ProductController@lengths')->name('product.lengths');
            /////////////// Product Sizes Routes //////////////////
            Route::resource('productSize','ProductSizeController');
            /////////////// Product Length Routes /////////////////
            Route::resource('productLength','ProductLengthController');
            /////////////// Product Weighment Units ///////////////
            Route::get('product/{id}/weighmentUnits','WeighmentUnitController@weighmentUnits')->name('weighmentUnit');
            Route::post('unit/store','WeighmentUnitController@storeUnit')->name('productUnit.store');
            Route::post('unit/destroy','WeighmentUnitController@destroyUnit')->name('productUnit.destroy');
        });
    });
});


