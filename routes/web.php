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
    return redirect()->route('login');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::view('/device', 'device')->name('device');
Route::post('/device/add', 'HomeController@addDevice')->name('device.add');
Route::post('/device/edit', 'HomeController@editDevice')->name('device.edit');
Route::post('/device/delete', 'HomeController@deleteDevice')->name('device.delete');

Route::get('/log/{key}', 'HomeController@logViewer')->name('log');
Route::get('/graph/{key}', 'HomeController@showGraph')->name('show.graph');
Route::get('/data/graph/{key}', 'HomeController@getGraph')->name('get.graph');

/* Nitip untuk generate Data Dosen Karyawan di tedi.sv.ugm.ac.id */
Route::get('/excel', 'ExcelController@index')->name('excel.index');
Route::post('/excel', 'ExcelController@import')->name('excel.import');