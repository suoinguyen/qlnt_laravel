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

Route::get('/', 'DashboardController@index');

//Phong
Route::get('/phong', 'PhongController@index')->name('room.list');
Route::get('/phong/tao-phong', 'PhongController@create')->name('room.create');
Route::post('/phong/tao-phong', 'PhongController@store')->name('room.store');
Route::get('/phong/xoa-phong/{id}', 'PhongController@destroy')->name('room.destroy');
Route::get('/phong/sua-phong/{id}', 'PhongController@edit')->name('room.edit');
Route::post('/phong/sua-phong/{id}', 'PhongController@update')->name('room.update');
