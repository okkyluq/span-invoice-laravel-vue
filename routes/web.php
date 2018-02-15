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

Route::get('/system/dashboard', 'BackController@home');


Route::get('/data/mahasiswa', 'MahasiswaController@getDataMahasiswa');
Route::post('/data/mahasiswa/store', 'MahasiswaController@storeDataMahasiswa');

Route::get('/data/invoice', 'invoiceController@getDataInvoice');
Route::post('/invoice', 'invoiceController@store');
Route::delete('/invoice/{id}', 'invoiceController@delete');
Route::get('/invoice/{id}', 'invoiceController@detail');
Route::put('/invoice', 'invoiceController@update');

Route::get('/auto/invoice', 'invoiceController@auto');


Route::get('{path}', function () {
    return view('back.layout');
})->where( 'path', '[\/\w\.-]*' );