<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/dashbord', function () {
    return view('dashboard.index');
})->name('dashboard');
Route::get('/penduduk', 'PendudukController@index')->name('penduduk.index');
Route::get('/penduduk/form', 'PendudukController@create')->name('penduduk.form');
Route::post('/penduduk/update', 'PendudukController@update')->name('penduduk.update');
Route::post('/penduduk/add', 'PendudukController@store')->name('penduduk.add');
