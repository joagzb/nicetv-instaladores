<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Auth Routes
|--------------------------------------------------------------------------
|
| rutas que tienen que ver con la sesion del usuario
|
*/

        
        # mostrar el formulario de login
        Route::get('/', function () {
            return view('auth.login');
        })->name('login_form');
        

        #enviar email con enlace
        Route::post('/password/reset', '\App\Http\Controllers\PasswordResetController@passwordReset')->name('email_recovery');

        #mostrar campos para ingresar la contrasena nueva
        Route::get('/password/{idusuario}/reset', '\App\Http\Controllers\PasswordResetController@showNewPasswordForm')
            ->name('email_form_recovery');

        #establecer la contrasena nueva
        Route::post('/password/{idusuario}/reset', '\App\Http\Controllers\PasswordResetController@saveNewPassword')
            ->name('post_email_form_recovery');
        
