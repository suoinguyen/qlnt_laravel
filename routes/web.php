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

Route::get('/', 'DashboardController@index')->name('dashboard');

//Room
Route::get('/phong', 'RoomController@index')->name('room.list');
Route::get('/phong/tao-phong', 'RoomController@create')->name('room.create');
Route::post('/phong/tao-phong', 'RoomController@store')->name('room.store');
Route::get('/phong/xoa-phong/{id}', 'RoomController@destroy')->name('room.destroy');
Route::get('/phong/sua-phong/{id}', 'RoomController@edit')->name('room.edit');
Route::post('/phong/sua-phong/{id}', 'RoomController@update')->name('room.update');
Route::get('/phong/dat-phong/{id}', 'RoomController@bookRoom')->name('room.bookRoom');
Route::post('/phong/dat-phong/{id}', 'RoomController@saveBookRoom')->name('room.saveBookRoom');

//Customer
Route::get('/khach', 'CustomerController@index')->name('customer.list');
Route::get('/khach/sua/{id}', 'CustomerController@edit')->name('customer.edit');
