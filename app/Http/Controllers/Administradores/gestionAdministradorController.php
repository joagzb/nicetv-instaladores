<?php

namespace App\Http\Controllers\Administradores;

use App\Http\Controllers\Controller;
use App\Models\admin;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class gestionAdministradorController extends Controller
{
    /*
     * muestra el formulario de alta para un administrador
     * */
    public function showCreateAdminForm()
    {
        return view('administrador.create_administrador');
    }

    /*
     * genera un nuevo perfil de administrador
     * */
    public function create(Request $request)
    {
        // validar los datos recibidos
        $request->validate([
            'input_nombre'   => 'required|max:100|min:8',
            'email-input'    => 'required|email',
            'password-input' => 'required',
            'radios'         => 'required',
        ]);

        $id_max_user = DB::table('users')
                         ->max('id');

        //crear un usuario
        try {
        $user = new User();
        $user->id = $id_max_user + 1;
        $user->name = $request->input('input_nombre');
        $user->telefono = "37040000000";
        $user->email = $request->input('email-input');
        $user->password = Hash::make($request->input('password-input'));
        $user->email_verified_at = Carbon::now()
                                         ->toDate();
        $user->type = User::USER_ADMIN_TYPE;
        $user->saveOrFail();

        //anexar usuario creado a un objeto ADMINISTRADOR
        $admin = new admin();
        $admin->id = $user->id;
        $admin->nivel = $request->input('radios');

        $admin->saveOrFail();
            $mensaje = 'Se ha creado al administrador ' . $user->name . ' con nivel de autoridad ' . $admin->nivel;
            $request->session()->flash('ok', $mensaje);
        } catch (\Throwable $e) {
            $mensaje = 'error al crear el administrador. Intente nuevamente';
            $request->session()->flash('error', $mensaje);
        }
        return redirect()->route('showAdminList');
    }

    /*
     * muestra una pantalla para editar un administrador
     * */
    public function showEditarAdmin()
    {
        return view('administrador.editar_administrador');
    }

    /*
     * aplicar los cambios en la actualizacion de datos de un administador
     * */
    public function editarAdmin(Request $request, $admin_id)
    {
        // determinar el tipo de operacion
        // 1 -> actualziar contraseña
        // 2 -> actualizar nivel de autoridad
        $nombre_admin = User::find($admin_id)->name;
        if ($request->input('op') == 1) {
            $request->validate([
                'input_contraseña'           => 'required|max:40|min:4',
                'input_confirmar_contraseña' => 'required|same:input_contraseña',
            ]);

            $contrasena = Hash::make($request->input('input_contraseña'));
            DB::table('users')
              ->where('id', '=', $admin_id)
              ->update(['password' => $contrasena]);
            $mensaje = 'La contraseña de ' . $nombre_admin . ' ha sido actualizada con exito';
        } else {
            if ($admin_id == Auth::user()->id) {
                return back()->withErrors(['error' => 'No puede cambiarse el nivel a usted mismo']);
            }
            DB::table('admin')
              ->where('id', '=', $admin_id)
              ->update(['nivel' => $request->input('radio1')]);
            $mensaje = 'El nivel de autoridad de ' . $nombre_admin . ' ha sido actualizado con éxito';
        }

        $request->session()->flash('ok', $mensaje);
        return redirect()->route('showAdminList');
    }

    /*
     * post para eliminar un administrador
     * */
    public function eliminar(Request $request)
    {
        //corroborar que un administrador no se esta eliminando a si mismo
        if ($request->input('id_admin') == Auth::user()->id) {
            return back()->withErrors(['error' => 'No puede eliminarse a usted mismo']);
        }
        $nombre_admin = User::find($request->input('id_admin'))->name;

        if (admin::find($request->input('id_admin'))->nivel == 3) {
            return back()->withErrors(['error' => 'No puede eliminar a un administrador con autoridad de nivel 3: "Super Usuario"']);
        }
        //eliminar los modelos
        admin::find($request->input('id_admin'))
             ->delete();
        User::find($request->input('id_admin'))
            ->delete();

        //redirigir
        $request->session()->flash('ok', 'Se ha eliminado al administrador ' . $nombre_admin);
        return redirect()->route('showAdminList');
    }
}
