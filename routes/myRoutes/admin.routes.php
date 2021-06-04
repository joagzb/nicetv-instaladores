<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Rutas del administrador
|--------------------------------------------------------------------------
|
| Son accedidadas unicamente por un administrador
|
*/
Route::middleware(['auth:sanctum', 'verified', 'role:admin'])
     ->group(function(){

         /*
          * Rutas solo accesibles para Administradores de nivel 2 o 3
          * */
         Route::middleware(['isAdminlvl2'])
              ->group(function(){
                  # editar preferencias de un instalador
                  Route::get('/admin/instaladores/{instalador_id}/editar', '\App\Http\Controllers\Administradores\GestionInstaladorController@showEditOptions')
                       ->name('showEditarInstalador');

                  # aplicar actualizacion de datos del instalador
                  Route::post('/admin/instaladores/{instalador_id}/editar', '\App\Http\Controllers\Administradores\GestionInstaladorController@editarInstalador')
                       ->name('EditarInstalador');

                  # post para bloquear un instalador
                  Route::post('/admin/instaladores/bloquear', '\App\Http\Controllers\Administradores\GestionInstaladorController@bloquear')
                       ->name('bloquearInstalador');

                  # post para eliminar un instalador
                  Route::post('/admin/instaladores/eliminar', '\App\Http\Controllers\Administradores\GestionInstaladorController@delete')
                       ->name('eliminarInstalador');

                  # mostrar 2 opciones: crear un instalador nuevo o importarlo
                  Route::get('/admin/instaladores/create/options/{option}', '\App\Http\Controllers\Administradores\GestionInstaladorController@showCreateOption')
                       ->name('showCreateInstaladorOptions');

                  # POST para crear un nuevo instalador
                  Route::post('/admin/instaladores/create/new', '\App\Http\Controllers\Administradores\GestionInstaladorController@PostCreateNewInstalador')
                       ->name('postCreateInstaladorForm');
              });

         /*
          * Rutas solo accesibles para Administradores de nivel 3
          * */
         Route::middleware(['isAdminlvl3'])
              ->group(function(){
                  # pantalla con listado de los administradores de esta plataforma
                  Route::get('/usuarios/administradores/create', '\App\Http\Controllers\Administradores\gestionAdministradorController@showCreateAdminForm')
                       ->name('showCreateAdminForm');

                  # mostrar panel para editar un instalador
                  Route::get('/usuarios/administradores/{admin_id}/editar', '\App\Http\Controllers\Administradores\gestionAdministradorController@showEditarAdmin')
                       ->name('showEditarAdmin');

                  # post para actualizar los datos de un administrador
                  Route::post('/usuarios/administradores/{admin_id}/editar', '\App\Http\Controllers\Administradores\gestionAdministradorController@editarAdmin')
                       ->name('editarAdmin');

                  # post para eliminar un administrador
                  Route::post('/usuarios/administradores/eliminar', '\App\Http\Controllers\Administradores\gestionAdministradorController@eliminar')
                       ->name('eliminarAdministrador');

                  # pantalla con listado de los administradores de esta plataforma
                  Route::post('/usuarios/administradores/create', '\App\Http\Controllers\Administradores\gestionAdministradorController@create')
                       ->name('createAdmin');

              });

         # mostrar un panel principal con los reclamos activos y quienes son los instaladores responsables de c/u
         Route::get('/admin/home', '\App\Http\Controllers\Administradores\HomeAdminController@index')
              ->name('showHomeAdmin');

         # muestra un listado de los cobradores
         Route::get('/admin/instaladores', '\App\Http\Controllers\Administradores\GestionInstaladorController@index')
              ->name('showInstaladores');

         # DESCARGA DE ARCHIVO - exportar el historial de reclamos atendidos en formato .csv
         Route::post('/admin/reclamos/reciente/export', '\App\Http\Controllers\Administradores\HistorialRecienteController@exportHistorialReciente')
              ->name('HistoricRecentToCSV');

         # mostrar los detalles de un reclamo resuelto
         Route::get('/admin/home/reclamos/historic/{idreclamo}/details', '\App\Http\Controllers\Administradores\HistorialRecienteController@verDetalleReclamo')
              ->name('showHistoricDetalleReclamoAdmin');

         # mostrar los detalles de un reclamo pendiente de resolverse
         Route::get('/admin/home/reclamos/{idreclamo}/details', '\App\Http\Controllers\Administradores\HomeAdminController@verDetalleReclamo')
              ->name('showDetalleReclamoAdmin');

         # mostrar mas detalles acerca de un instalador
         Route::get('/admin/instaladores/{instalador_id}/detail', '\App\Http\Controllers\Administradores\GestionInstaladorController@showDetailInstalador')
              ->name('showDetailInstalador');

         # exportar un archivo historico de un instalador
         Route::post('/admin/instaladores/{instalador_id}/exportHistoric', '\App\Http\Controllers\Administradores\GestionInstaladorController@Historic2CSV')
              ->name('HistoricToCSV');

     });
//===========================================================================
