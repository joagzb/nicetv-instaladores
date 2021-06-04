<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Rutas del instalador
|--------------------------------------------------------------------------
|
| Son accedidadas unicamente por un instalador que ha iniciado sesion
|
*/
Route::middleware(['auth:sanctum', 'verified', 'role:instalador'])
     ->group(function(){
         # mostrar la pantalla principal con un listado con todos los reclamos pendientes
         Route::get('/home', '\App\Http\Controllers\Instaladores\HomeInstaladorController@index')
              ->name('showHome');

         # mostrar mas detalles de de reclamo
         Route::get('/home/{Arg_idreclamo}/detalles', '\App\Http\Controllers\Instaladores\HomeInstaladorController@detalleReclamo')
              ->name('showDetalleReclamo');

         # POST para resolver un reclamo
         Route::post('/home/{Arg_idreclamo}/detalles/solve', '\App\Http\Controllers\Instaladores\HomeInstaladorController@resolverReclamo')
              ->name('post_resolverReclamo');

         # mostrar el formulario de instalacion para activar el deco
         Route::get('/home/{Arg_idreclamo}/detalles/activacion', '\App\Http\Controllers\Instaladores\HomeInstaladorController@formActivacion')
              ->name('showFormActivacion');

         # POST formulario para activar el deco
         Route::post('/home/{Arg_idreclamo}/detalles/activacion', '\App\Http\Controllers\Instaladores\HomeInstaladorController@activarDeco')
              ->name('post_activarDeco');

         # muestra un historial con todos los reclamos y solicitudaes atendidas
         Route::get('/historial', '\App\Http\Controllers\Instaladores\HistorialReclamoController@index')
              ->name('showHistorialVisitas');

         # muestra un historial con todos los reclamos y solicitudaes atendidas
         Route::get('/historial/{idreclamo}/detalles', '\App\Http\Controllers\Instaladores\HistorialReclamoController@detalleReclamo')
              ->name('showDetalleHistorial');

         # muestra un historial con todos los reclamos y solicitudaes atendidas
         Route::post('/historial/exportCSV', '\App\Http\Controllers\Instaladores\HistorialReclamoController@exportHistorial')
              ->name('exportHistorial');

     });
//===========================================================================
