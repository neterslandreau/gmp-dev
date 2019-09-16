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

use App\Item;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes(['verify' => true]);

Route::get('/home', 'HomeController@index')->name('home')->middleware('verified');
Route::get('/store', 'HomeController@store')->name('store')->middleware('verified');
Route::post('/store', 'HomeController@store');

Route::get('/items/import', 'ItemsController@import')->name('items.import');
Route::get('/items/import_sales', 'ItemsController@import_sales');
Route::get('/items/import_lists', 'ItemsController@import_lists');

Route::post('/items/get_by_store', 'ItemsController@get_by_store');
Route::post('/sales/get_by_store', 'SalesController@get_by_store');
Route::post('/invoices/get_by_store', 'InvoiceController@get_by_store');

Route::get('/items/download', 'ItemsController@download')->name('items.download');

Route::post('/getItems', function (Request $request) {
    if (request()->ajax()) {

        echo json_encode(Item::where('store_nbr', '=', str_pad(request('store_nbr'), 4, '0', STR_PAD_LEFT))->paginate(10));

    }

});

//Route::get('/invoices', 'InvoiceController@index')->name('invoices.list');

//Route::get('/live_search', 'LiveSearch@index');
Route::get('/items/search', 'ItemsController@search')->name('items.search');
Route::get('/sales/search', 'SalesController@search')->name('sales.search');

Route::get('/test', 'UsersController@test');

Route::get('/items', 'ItemsController@index');

Route::get('/sales', 'SalesController@index');

Route::get('/purchases', 'InvoiceController@index');

Route::get('/analytics', 'ItemsController@analytics');

Route::get('/store_config', 'StoresController@get_config');

Route::get('/users', 'UsersController@index')->name('users.list')->middleware('verified');
Route::get('/users/create', 'UsersController@create')->name('users.create')->middleware('verified');
Route::get('/users/{id}/edit', 'UsersController@edit')->name('users.edit')->middleware('verified');
Route::get('/users/{id}/delete', 'UsersController@delete')->name('users.destroy')->middleware('verified');
Route::get('/users/{id}', 'UsersController@show')->name('users.show')->middleware('verified');
Route::post('/users/{id}/update', 'UsersController@update')->name('users.update')->middleware('verified');
Route::post('/users', 'UsersController@store');

Route::get('/stores', 'StoresController@index')->name('stores.list')->middleware('verified');
Route::get('/stores/create', 'StoresController@create')->name('stores.create')->middleware('verified');
Route::get('/stores/{id}/edit', 'StoresController@edit')->name('stores.edit')->middleware('verified');
Route::get('/stores/{id}/delete', 'StoresController@delete')->name('stores.destroy')->middleware('verified');
Route::get('/stores/{id}', 'StoresController@show')->name('stores.show')->middleware('verified');
Route::post('/stores/{id}/update', 'StoresController@update')->name('stores.update');
Route::post('/stores', 'StoresController@store');
Route::post('/get_ids', 'StoresController@get_ids')->name('stores.get_ids');

Route::get('/invoices', 'InvoiceController@index');
Route::post('/invoices/{id}/{date}/get', 'InvoiceController@get');
Route::post('/invoices/get_delivery_dates', 'InvoiceController@get_delivery_dates');
