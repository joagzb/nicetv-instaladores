<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Rutas multiusuario
|--------------------------------------------------------------------------
|
| Son accedidadas por cualquier usuario que haya iniciado sesion
|
*/
Route::middleware(['auth:sanctum', 'verified'])
     ->group(function(){

         # muestra un panel con guias y tutoriales sobre la plataforma
         Route::get('/help', '\App\Http\Controllers\AyudaController@index')
              ->name('showAyuda');

         # mostrar un listado de los administradores de la plataforma
         Route::get('/usuarios/administradores', '\App\Http\Controllers\UsuariosController@showAdminList')
              ->name('showAdminList');

         # VISTA - muestra la pantalla de configuracion de perfil del usuario
         Route::get('/usuarios/self/profile/settings', '\App\Http\Controllers\UsuariosController@index')
              ->name('userProfileSettings');

     });
//===========================================================================
