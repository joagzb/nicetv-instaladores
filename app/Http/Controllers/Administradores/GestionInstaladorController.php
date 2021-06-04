<?php

namespace App\Http\Controllers\Administradores;

use App\Http\Controllers\Controller;
use App\Models\instalador;
use App\Models\User;
use App\repository\PlataformaCobradoresAPI;
use App\Traits\adminTrait;
use App\Traits\clienteTrait;
use App\Traits\instaladorTrait;
use App\Traits\presenter;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;
use Throwable;

class GestionInstaladorController extends Controller {
    /*
     * TRAITS
     * */
    use adminTrait;
    use clienteTrait;
    use instaladorTrait;
    use presenter;

    /*
     * VISTA - ver un listado de todos los instaladores
     * */
    public function index(Request $request){
        $lista_instaladores = $this->fetchInstaladores();

        return view('administrador.lista_instaladores', [
            'lista_instaladores' => $lista_instaladores,
        ]);
    }

    /*
     * VISTA - mostrar un formulario para crear un nuevo instalador
     * */
    public function showCreateOption(Request $request, $option){
        switch ($option){
            case 'wrapper':
                $jsonCobradores = PlataformaCobradoresAPI::getUsersCobradores();
                return view('administrador.wrapperNewInstalador',['usersCobradores'=>$jsonCobradores]);
                break;
            case 'nuevo':
                if($request->has('userCobrador')){
                    $jsonCobrador = PlataformaCobradoresAPI::getUsersCobradorByID($request->get('userCobrador'));
                    $tecnicos_billing = null;
                }else{
                    $tecnicos_billing = $this->API_fetchInstaladores();
                    $jsonCobrador = null;
                }

                if(!isset($jsonCobrador) && !isset($tecnicos_billing)){
                    return back()->withErrors(['error'=>"No se ha encontrado al técnico solicitado en la plataforma de cobradores."]);
                }

                return view('administrador.create_instalador', ['instaladores_billing' => $tecnicos_billing,'userCobrador'=>$jsonCobrador[0]]);
                break;
        }
    }

    /*
     * VISTA - mostrar pantalla de detalles de un instalador
     * */
    public function showDetailInstalador(Request $request, $id_instalador){
        // obtener todos los detalles de interes
        $instalador = $this->getInstalador($id_instalador);
        $historial_instalador = $this->getHistorialInstalador($id_instalador);
        $admin_responsable_alta = $this->getAdmin($instalador->id_admin_responsable_alta);

        //integrar todos los datos
        $instalador->historial_reclamos_atendidos = $historial_instalador;
        $instalador->admin_responsable = $admin_responsable_alta;

        return view('administrador.detalle_instalador', [
            'detalle_instalador' => $instalador,
        ]);
    }

    /*
     * VISTA - muestra la pantalla para editar propiedades del instalador
     * */
    public function showEditOptions(Request $request, $id_instalador){
        $detalle_instalador = $this->getInstalador($id_instalador);
        return view('administrador.editar_instalador', [
            'detalle_instalador' => $detalle_instalador,
        ]);
    }

    /*
     * POST - bloquear un instalador
     * */
    public function bloquear(Request $request){
        $ishabilitado = DB::table('instalador')
                          ->where('id', '=', $request->input('id_instalador'))
                          ->get('habilitado');

        if ($ishabilitado[0]->habilitado == 1) {
            DB::table('instalador')
              ->where('id', '=', $request->input('id_instalador'))
              ->update([
                  'habilitado' => 0,
              ]);
            $mensaje = "Se ha bloqueado al instalador";
        } else {
            DB::table('instalador')
              ->where('id', '=', $request->input('id_instalador'))
              ->update([
                  'habilitado' => 1,
              ]);
            $mensaje = "Se ha habilitado nuevamente al instalador";
        }

        //responder con un mensaje al frontend
        $request->session()->flash('ok', $mensaje);
        return redirect()->route('showInstaladores');
    }

    /*
     * POST -  actualizar datos del instalador
     * */
    public function editarInstalador(Request $request, $instalador_id){
        $tipo_operacion = $request->input('op');

        switch ($tipo_operacion) {
            case 1: //cambiar contrasena
                $request->validate([
                    'input_contraseña'           => 'required|max:40|min:4',
                    'input_confirmar_contraseña' => 'required|same:input_contraseña',
                ]);

                $contrasena = Hash::make($request->input('input_contraseña'));
                DB::table('users')
                  ->where('id', '=', $instalador_id)
                  ->update(['password' => $contrasena]);
                $mensaje = "La contraseña ha sido actualizada con exito";
                break;
            case 2:
                break;
            case 3: // cambiar datos personales
                $request->validate([
                    'input_telefono' => 'required|numeric|digits_between:8,15',
                    'email-input'    => 'required|email',
                ]);
                User::all()
                    ->find($instalador_id)
                    ->update([
                        'email'    => $request->input('email-input'),
                        'telefono' => $request->input('input_telefono'),
                    ]);
                $mensaje = "Los datos han sido actualizados con éxito";
                break;
        }

        $request->session()->flash('ok', $mensaje);
        return redirect()->route('showInstaladores');
    }

    /*
     * POST - eliminar un instalador de la base de datos
     * */
    public function delete(Request $request){
        $instalador = instalador::find($request->input('id_instalador'));
        $nombre_instalador = User::find($request->input('id_instalador'))->name;
        $instalador->delete();
        User::destroy($request->input('id_instalador'));
        $request->session()->flash('ok', 'se ha eliminado al instalador ' . $nombre_instalador);
        return redirect()->route('showInstaladores');
    }

    /*
    * POST - crear un instalador nuevo
    * */
    public function PostCreateNewInstalador(Request $request){
        // validar los datos recibidos
        $request->validate([
            'input_nombre'   => 'required|string|min:5|max:50',
            'input_telefono' => 'required|numeric|digits_between:7,15',
            'tecnico'        => ['required', Rule::notIn(['-1'])],
            'email-input'    => 'required|email|unique:users,email',
            'password-input' => 'required|string|min:4|max:20',
        ]);

        //obtener el perfil completo del tecnico
        try {
            DB::beginTransaction();
            $tecnico = $this->API_fullTecnicoDetail($request->input('tecnico'));

            if(!isset($tecnico)){
                return back()->withErrors(['error'=>"No se ha encontrado el técnico solicitado en billing"]);
            }

            // obtener los datos por request
            $user = new User();
            $user->id = $tecnico->id;
            $user->name = $request->input('input_nombre');
            $user->email = $request->input('email-input');
            $user->telefono = $request->input('input_telefono');
            $user->email_verified_at = Carbon::now()->toDate();
            $user->password = Hash::make($request->input('password-input'));

            // procesar la informacion y guardar modelos
            $user->saveOrFail();

            // crear el perfil instalador en base al usuario
            $instalador = new instalador();
            $instalador->id = $user->id;
            $instalador->habilitado = 1; //este valor cambiara a 1 cuando complete la direccion de su local
            $instalador->id_admin_responsable_alta = Auth::user()->id;
            $instalador->saveOrFail();

            $mensaje = 'perfil de instalador ha sido creado exitosamente';
            $request->session()->flash('ok', $mensaje);
            DB::commit();
        } catch (Throwable $e) {
            DB::rollBack();
            $mensaje = 'error al crear perfil de instalador';
            Log::info($e->getMessage());
            Log::info($e->getTraceAsString());
            $request->session()->flash('error', $mensaje);

        }

        return redirect()->route('showInstaladores');
    }

    /*
     * genenerar un archivo CSV con el historial de reclamos atendidos de un instalador en particular
     * */
    public function Historic2CSV(Request $request, $instalador_id){
        $fecha_desde = $request->input('fecha_desde');
        $arreglo_archivo = $this->exportHistoricInstalador($fecha_desde, $instalador_id);

        return response()
            ->download($arreglo_archivo[0], $arreglo_archivo[1], $arreglo_archivo[2])
            ->deleteFileAfterSend();
    }
}
