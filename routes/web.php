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

    Route::get('/data/jenis-kelamin', 'DashboardController@data_jenis_kelamin')->name('data.jenis_kelamin');
    Route::get('/data/jumlah-penduduk', 'DashboardController@data_jumlah_penduduk')->name('data.jumlah_penduduk');
    Route::get('/data/agama', 'DashboardController@data_agama')->name('data.agama');
    Route::get('/data/umur', 'DashboardController@data_umur')->name('data.umur');
    Route::get('/penduduk', 'PendudukController@index')->name('penduduk.index');
    Route::get('/penduduk/form', 'PendudukController@create')->name('penduduk.form');
    Route::get('/penduduk/data/detail/{id}', 'PendudukController@show')->name('penduduk.detail');
    Route::get('/penduduk/laporan', 'LaporanController@index')->name('laporan.index');
    Route::post('/penduduk/update', 'PendudukController@update')->name('penduduk.update');
    Route::post('/penduduk/add', 'PendudukController@store')->name('penduduk.add');

    // GET DATA PINDAH
    Route::get('/penduduk/data/pindah/{nik}', 'PendudukController@data_pindah')->name('penduduk.pindah');

    // GET DATA KECAMATAN
    Route::get('/data/kecamatan', 'PendudukController@data_kecamatan')->name('data.kecamatan');
    // GET CHECK NIK 
    Route::get('/data/nik/check', 'PendudukController@check_nik')->name('check.nik');
    Route::get('/download/data/penduduk', 'LaporanController@penduduk_export')->name('download.penduduk');
});
