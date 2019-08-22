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
Route::middleware(['checkSetting'])->group(function () {
    Route::get('/', 'DashboardController@index')->name('dashboard');
    Route::get('/thu-tien', 'DashboardController@collectMoney')->name('collect.money');
    //Room
    Route::get('/phong', 'RoomController@index')->name('room.list');
    Route::get('/phong/tao-phong', 'RoomController@create')->name('room.create');
    Route::post('/phong/tao-phong', 'RoomController@store')->name('room.store');
    Route::get('/phong/xoa-phong/{id}', 'RoomController@destroy')->name('room.destroy');
    Route::get('/phong/sua-phong/{id}', 'RoomController@edit')->name('room.edit');
    Route::post('/phong/sua-phong/{id}', 'RoomController@update')->name('room.update');
    Route::get('/phong/dat-phong/{id}', 'RoomController@bookRoom')->name('room.bookRoom');
    Route::post('/phong/dat-phong/{id}', 'RoomController@saveBookRoom')->name('room.saveBookRoom');
    Route::get('/phong/{id}', 'RoomController@show')->name('room.show');
    Route::get('/phong/tra-phong/{id}', 'RoomController@checkoutRoom')->name('room.checkoutRoom');
    Route::get('/phong/thanh-toan/{id}', 'RoomController@payBill')->name('room.payBill');
    Route::post('/phong/thanh-toan/{id}', 'RoomController@doPayBill')->name('room.doPayBill');
    Route::get('/phong/chot-so/{id}', 'RoomController@calcMoney')->name('room.calcMoney');
    Route::post('/phong/chot-so/{id}', 'RoomController@doCalcMoney')->name('room.doCalcMoney');

    //Customer
    Route::get('/khach', 'CustomerController@index')->name('customer.list');
    Route::get('/khach/sua/{id}', 'CustomerController@edit')->name('customer.edit');
    Route::post('/khach/sua/{id}', 'CustomerController@update')->name('customer.update');
    Route::get('/khach/{id}', 'CustomerController@show')->name('customer.show');

    //Contract
    Route::get('/hop-dong/{id}', 'CustomerController@show')->name('contract.show');
});

//Config
Route::get('/cai-dat', 'SettingController@index')->name('app.config');
Route::post('/cai-dat/luu', 'SettingController@saveSetting')->name('app.config.save');


