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

Route::get('/items/download', 'ItemsController@download')->name('items.download');

//Route::get('/invoices', 'InvoiceController@index')->name('invoices.list');

//Route::get('/live_search', 'LiveSearch@index');
Route::get('/items/search', 'ItemsController@search')->name('items.search');
Route::get('/sales/search', 'SalesController@search')->name('sales.search');

Route::get('/test', 'UsersController@test');

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
