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

