<?php

namespace App\Http\Controllers\Instaladores;

use App\Http\Controllers\Controller;
use App\Models\instalador;
use App\Traits\clienteTrait;
use App\Traits\reclamoTrait;
use Carbon\Carbon;
use Hamcrest\Text\StringContains;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Throwable;

class HomeInstaladorController extends Controller {
    /*
     * incluir las funciones API de conexion con la BD de Luis
     * */
    use clienteTrait;

    /*
     * VISTA - mostrar pantalla principal con los reclamos pendientes
     * */
    public function index(Request $request){
        $instalador = instalador::getCurrentInstalador();
        if (!$instalador->habilitado()) {
            return view('home', ['habilitado' => false]);
        }

        // tomar los reclamos asignados al instalador actual
        $reclamos_pendientes = $instalador->getCurrentReclamos();
        
        // filtrar los de mayor prioridad
        $reclamos_prioritarios = array_filter($reclamos_pendientes->items(), function($elem){
            return $elem->prioridad > 0;
        });

        //filtrar las localidades para la funcion de filtrar por localidad en el frontend
        $localidades_reclamos = array_column($reclamos_pendientes->items(), 'localidad');
        $localidades_reclamos = array_column($localidades_reclamos, 'padre');
        $localidades_reclamos = array_unique($localidades_reclamos);
        return view('home', [
            'habilitado'         => true,
            'reclamos'           => $reclamos_pendientes,
            'localidades'        => $localidades_reclamos,
            'reclamos_prioridad' => $reclamos_prioritarios,
        ]);
    }

    /*
     * VISTA - mostrar mas detalles sobre un reclamo
     * */
    public function detalleReclamo(Request $request, $Arg_idreclamo){

        // obtener mas detalles acerca de un reclamo
        $idreclamo = decrypt($Arg_idreclamo);
        $detalle_reclamo = $this->getReclamoDetails($idreclamo);

        // configurar google maps para que puedan ver la ubicacion del abonado
        if (isset($detalle_reclamo->localidad_cliente)) {
            $link_gmaps = 'https://www.google.com/maps/search/?api=1&query=' . $detalle_reclamo->localidad_cliente->latitud . ',' . $detalle_reclamo->localidad_cliente->longuitud . '&zoom=13';
            $detalle_reclamo->link_gmaps = $link_gmaps;
        }
        
        return view('detalle_reclamo', ['detalle_reclamo' => $detalle_reclamo]);
    }

    /*
     * VISTA - mostrar formulario de activacion de deco
     * */
    public function formActivacion(Request $request, $Arg_idreclamo){
        return view('formulario_activacion_deco',['cliente_info'=>$request->get('params')]);
    }

    /*
     * POST - formulario de activacion de deco
     * */
    public function activarDeco(Request $request, $Arg_idreclamo){
        $request->validate([
            'nombre'        => 'required|string|min:6|max:100',
            'dni'           => 'required|numeric|digits_between:8,12',
            'telefono'      => 'required|numeric|digits_between:8,20',
            'email'         => 'email|nullable',
            'calle'         => 'required|string|min:6|max:50',
            'casa_nro'      => 'required|numeric',
            'tipo_servicio' => 'required|string|min:1',
            'kid1'          => 'required|string|min:1',
        ]);

        // configurar las variables todo: descomentar para actualziar estado en billing
//        try {
//            DB::beginTransaction();
//            $idreclamo = decrypt($Arg_idreclamo);
//            $reclamo = $this->getReclamoDetails($idreclamo);
//
//            $kid1 = $request->input('kid1');
//            $kid2 = $request->input('kid2');
//            if (isset($kid2)) {
//                $kid = $kid1 . ',' . $kid2;
//            } else {
//                $kid = $kid1;
//            }
//
//            $params = [
//                'motivo'                  => $reclamo->motivo,
//                'fecha_realizacion'       => Carbon::now()->toDate(),
//                'kid'                     => $kid,
//                'deco1'                   => $reclamo->deco != NULL ? $reclamo->deco : "",
//                'deco2'                   => $reclamo->deco2 != NULL ? $reclamo->deco2 : "",
//                'estado'                  => $reclamo->des_estado,
//                'fecha_reclamo'           => $reclamo->fechareclamo,
//                'localidad'               => $reclamo->localidad_cliente->ciudad . '-' . $reclamo->localidad_cliente->padre,
//                'dni'                     => $request->input('dni'),
//                'email'                   => $request->input('email'),
//                'telefono'                => $request->input('telefono'),
//                'observaciones'           => $request->input('detalle') != NULL ? $request->input('detalle') : "",
//                'tipo_servicio'           => $request->input('tipo_servicio'),
//                'calle'                   => $request->input('calle'),
//                'calle_altura'            => $request->input('casa_nro'),
//                'barrio'                  => $request->input('barrio'),
//                'nroabonado'              => $reclamo->idabonado,
//                'abonado_nombre_apellido' => $reclamo->cliente_info->nombre . ' ' . $reclamo->cliente_info->apellido,
//                'id_reclamo'              => $idreclamo,
//                'id_instalador'           => Auth::user()->id,
//                'nombre_instalador'       => Auth::user()->name,
//            ];
//
//            // escribir datos en la tabla "instalacion"
//            reclamoTrait::resolverInstalacion($params);
//
//            // escribir datos en la tabla "historial"
//            reclamoTrait::recordHistorial($params);
//
//            //marcar reclamo resuleto en billing
//            $this->resolver($idreclamo, $params);
//
//            // resolver instalacion en billing, enviando una activacion temporal
//            $this->enviarActivacion();
//
//            Log::channel('registro_soluciones')
//               ->info('Instalación realizada. reclamo:' . $params['id_reclamo'] . ',motivo:'
//                   . $params['motivo'] . ',abonado:' . $reclamo->idabonado . ',instalador:' . $params['nombre_instalador'] . '/' . $params['id_instalador']);
//            $request->session()->flash('ok', "Se ha resuelto el reclamo.");
//            DB::commit();
//        } catch (Throwable $e) {
//            DB::rollBack();
//            Log::channel('incidente_soluciones')->info('----INICIO ERROR EN INSTALACION----');
//            Log::channel('incidente_soluciones')->info($e->getMessage());
//            Log::channel('incidente_soluciones')
//               ->info('DETALLES. id_instalador:' . Auth::user()->id . ',id_reclamo:' . $idreclamo);
//            Log::channel('incidente_soluciones')->info($e->getTraceAsString());
//            Log::channel('incidente_soluciones')->info('----FIN ERROR EN INSTALACION----');
//            $request->session()->flash('error', "Ha ocurrido un error. No se ha resuelto la instalación");
//        }

        return redirect()->route('showHome');
    }

    /*
     * POST - marcar un reclamo como resuelto
     * */
    public function resolverReclamo(Request $request, $Arg_idreclamo){
        $request->validate([
            'check_dni'      => ['required', Rule::in(['on'])],
            'dni'            => 'required|numeric|digits_between:8,12',
            'check_email'    => ['required', Rule::in(['on'])],
            'email'          => [
                'required',
                Rule::notIn([
                    's/n@live.com.ar',
                    'test@test.com',
                    'SN@LIVE.COM',
                    'S/N@LIVE.COM',
                    'S/N@GMAIL.COM',
                    'NA@LIVE.COM',
                    'S/n@LIVE.COM',
                ]),
                'email',
                'min:6',
                'max:80',
            ],
            'check_telefono' => ['required', Rule::in(['on'])],
            'telefono'       => 'required|numeric|digits_between:8,15',
        ]);

        // configurar las varibales todo: descomentar para actualziar estado en billing
//        try {
//            DB::beginTransaction();
//            $idreclamo = decrypt($Arg_idreclamo);
//            $reclamo = $this->getReclamoDetails($idreclamo);
//            $params = [
//                'motivo'                  => $reclamo->motivo,
//                'kid'                     => $reclamo->deco . " - " . $reclamo->deco2,
//                'fecha_realizacion'       => Carbon::now()->toDate(),
//                'deco1'                   => $reclamo->deco != NULL ? $reclamo->deco : "",
//                'deco2'                   => $reclamo->deco2 != NULL ? $reclamo->deco2 : "",
//                'estado'                  => $reclamo->des_estado,
//                'fecha_reclamo'           => $reclamo->fechareclamo,
//                'localidad'               => $reclamo->localidad_cliente->ciudad . '-' . $reclamo->localidad_cliente->padre,
//                'dni'                     => trim($request->input('dni')),
//                'email'                   => trim($request->input('email')),
//                'telefono'                => trim($request->input('telefono')),
//                'observaciones'           => trim($request->input('detalle')),
//                'nroabonado'              => $reclamo->idabonado,
//                'abonado'              => $reclamo->cliente_info->nroabonado,
//                'abonado_nombre_apellido' => $reclamo->cliente_info->nombre . ' ' . $reclamo->cliente_info->apellido,
//                'id_reclamo'              => $idreclamo,
//                'id_instalador'           => Auth::user()->id,
//                'nombre_instalador'       => Auth::user()->name,
//            ];
//
//            // escribir datos en la tabla "historial"
//            reclamoTrait::recordHistorial($params);
//
//            //marcar reclamo resuleto en billing
//            $this->resolver($idreclamo, $params);
//
//            Log::channel('registro_soluciones')
//               ->info('Reclamo resuelto. reclamo:' . $params['id_reclamo'] . ',motivo:'. $params['motivo'] . ',abonado:' . $params['abonado'] . ',instalador:' . $params['nombre_instalador'] . '/' . $params['id_instalador']);
//            $request->session()->flash('ok', "Se ha resuelto el reclamo.");
//            DB::commit();
//        } catch (Throwable $e) {
//            DB::rollBack();
//            Log::channel('incidente_soluciones')->info('----INICIO ERROR EN RECLAMO TECNICO----');
//            Log::channel('incidente_soluciones')->info($e->getMessage());
//            Log::channel('incidente_soluciones')
//               ->info('DETALLES. id_instalador:' . Auth::user()->id . ',id_reclamo:' . $idreclamo);
//            Log::channel('incidente_soluciones')->info($e->getTraceAsString());
//            Log::channel('incidente_soluciones')->info('----FIN ERROR EN RECLAMO TECNICO----');
//            $request->session()->flash('error', "Ha ocurrido un error. No se ha resuelto el reclamo");
//        }


        return redirect()->route('showHome');
    }
}
