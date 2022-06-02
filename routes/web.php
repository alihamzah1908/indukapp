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

Route::get('/', function () {
    return view('auth.login');
})->name('login');
Route::get('/auth/proseslogin', 'AuthController@proseslogin')->name('proses.login');
Route::group(['middleware' => 'auth'], function () {
    Route::get('/auth/logout', 'AuthController@logout')->name('logout');
    Route::get('/dashbord', function () {
        return view('dashboard.index');
    })->name('dashboard');
    Route::get('/penduduk', 'PendudukController@index')->name('penduduk.index');
    Route::get('/penduduk/form', 'PendudukController@create')->name('penduduk.form');
    Route::post('/penduduk/update', 'PendudukController@update')->name('penduduk.update');
    Route::post('/penduduk/add', 'PendudukController@store')->name('penduduk.add');

    // GET DATA PINDAH
    Route::get('/penduduk/data/pindah/{nik}', 'PendudukController@data_pindah')->name('penduduk.pindah');
});
