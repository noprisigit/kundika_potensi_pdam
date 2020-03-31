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

Route::get('/', 'HomeController@index');
Route::get('/potensi-pemakaian', function () {
    return view('pemakaian');
});
Route::get('/test', function () {
    return view('index');
});
Route::get('/potensi-penagihan', function () {
    return view('penagihan');
});
Route::get('/potensi-tunggakan', function () {
    return view('tunggakan');
});
Route::get('/vendor', function () {
    return view('vendor');
});

Route::get('/data', 'TestController@index');
Route::get('/proses', 'HomeController@proses');
Route::get('/search', 'HomeController@search');
Route::get('/penagihan', 'HomeController@penagihan');
Route::get('/tunggakan', 'HomeController@tunggakan');
Route::post('/proses-vendor', 'HomeController@vendor');