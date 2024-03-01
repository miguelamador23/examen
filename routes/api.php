<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and are assigned to the "api" middleware group.
| Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::get('/clientes', 'ClienteController@index');
Route::post('/clientes', 'ClienteController@store');
Route::get('/clientes/{id}', 'ClienteController@show');
Route::put('/clientes/{id}', 'ClienteController@update');
Route::delete('/clientes/{id}', 'ClienteController@destroy');


Route::get('/trabajadores', 'TrabajadorController@index');
Route::post('/trabajadores', 'TrabajadorController@store');
Route::get('/trabajadores/{id}', 'TrabajadorController@show');
Route::put('/trabajadores/{id}', 'TrabajadorController@update');
Route::delete('/trabajadores/{id}', 'TrabajadorController@destroy');


Route::get('/ventas', 'VentaController@index');
Route::post('/ventas', 'VentaController@store');
Route::get('/ventas/{id}', 'VentaController@show');
Route::put('/ventas/{id}', 'VentaController@update');
Route::delete('/ventas/{id}', 'VentaController@destroy');


Route::get('/detalle_ventas', 'DetalleVentaController@index');
Route::post('/detalle_ventas', 'DetalleVentaController@store');
Route::get('/detalle_ventas/{id}', 'DetalleVentaController@show');
Route::put('/detalle_ventas/{id}', 'DetalleVentaController@update');
Route::delete('/detalle_ventas/{id}', 'DetalleVentaController@destroy');


Route::get('/articulos', 'ArticuloController@index');
Route::post('/articulos', 'ArticuloController@store');
Route::get('/articulos/{id}', 'ArticuloController@show');
Route::put('/articulos/{id}', 'ArticuloController@update');
Route::delete('/articulos/{id}', 'ArticuloController@destroy');


Route::get('/detalle_ingresos', 'DetalleIngresoController@index');
Route::post('/detalle_ingresos', 'DetalleIngresoController@store');
Route::get('/detalle_ingresos/{id}', 'DetalleIngresoController@show');
Route::put('/detalle_ingresos/{id}', 'DetalleIngresoController@update');
Route::delete('/detalle_ingresos/{id}', 'DetalleIngresoController@destroy');
