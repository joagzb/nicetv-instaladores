<?php

namespace App\Http\Controllers;

use App\Models\admin;
use App\Models\User;
use Illuminate\Http\Request;

class UsuariosController extends Controller {

    /*
     * VISTA - muestra el panel de configuracion de usuario
     * */
    public function index(){
        return view('preferencias_usuario');
    }

    /*
     * VISTA - muestra la lista de administradores del sistema
     * */
    public function showAdminList(){
        $lista_admins = User::all()
                            ->where('type', '=', 'admin');
        foreach ($lista_admins as $a) {
            $a->lvl = admin::find($a->id)->nivel;
        }
        return view('lista_administradores', ['lista_admins' => $lista_admins]);
    }


}
