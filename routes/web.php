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

Route::get('/users', 'UsersController@index');
Route::get('/users/create', 'UsersController@create')->name('users.create');
Route::get('/users/{id}/edit', 'UsersController@edit')->name('users.edit');
Route::get('/users/{id}/delete', 'UsersController@delete')->name('users.destroy');
Route::get('/users/{id}', 'UsersController@show')->name('users.show');
Route::post('/users/{id}/update', 'UsersController@update')->name('users.update');
Route::post('/users', 'UsersController@store');

Route::get('/stores/create', 'StoresController@create')->name('stores.create');
Route::get('/stores/{id}/edit', 'StoresController@edit')->name('stores.edit');
Route::get('/stores/{id}/delete', 'StoresController@delete')->name('stores.destroy');
Route::get('/stores/{id}', 'StoresController@show')->name('stores.show');
Route::post('/stores/{id}/update', 'StoresController@update')->name('stores.update');
Route::post('/stores', 'StoresController@store');

