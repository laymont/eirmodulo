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

Route::get('/inicio', function () {
    return view('index');
})->name('5xplus.inicio');

Route::resource('lineas', 'LineaController');

/* Lineas */
Route::get('/getBuques/{linea}', 'BuqueController@getBuques')->name('lineas.getBuques');

/* Buques */

/* Viajes */
Route::get('/getViajes/{buque}', 'ViajeController@getViajes')->name('viajes.getViajes');

/* Tipos */
Route::get('/getTipos','TequipoController@getTipos')->name('tipos.getTipos');
Route::get('/getIsoCodes/{tipo}', 'IsocodecontainerController@getIsoCodes')->name('tipos.getIsoCodes');

/* EIR's */
Route::get('eirs/out/{id}', 'EirController@out')->name('eirs.out');
Route::resource('eirs', 'EirController');

Route::resource('inventarios', 'InventarioController');
