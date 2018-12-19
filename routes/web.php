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

/*Route::get('/', function () {
    return view('welcome');
});*/

Route::prefix('api/v1.1')->group(function () {
  Route::get('/fabricantes','FabricanteController@index');
  Route::get('/fabricantes/{id}','FabricanteController@show');
  Route::post('/fabricante','FabricanteController@store');
  Route::post('/create-vehiculo/{id}','FabricanteVehiculoController@store');
  Route::get('/vehiculos','VehiculoController@index');
  Route::get('/vehiculos/{id}','VehiculoController@show');
  Route::get('/fabricantes/{fabricante_id}/vehiculos','FabricanteVehiculoController@index');
});
