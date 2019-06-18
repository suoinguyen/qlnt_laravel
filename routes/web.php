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
    return view('dashboard');
});

//Phong
Route::get('/phong', 'PhongController@index')->name('room.list');
Route::get('/phong/tao-phong', 'PhongController@create')->name('room.create');
Route::post('/phong/tao-phong', 'PhongController@store')->name('room.store');
