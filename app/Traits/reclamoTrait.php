<?php

namespace App\Traits;

/*===================================================================
 * FUNCIONES QUE OPERAN SOBRE LOS RECLAMOS
 * ===================================================================*/

use App\Models\historial_arreglos;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

trait reclamoTrait {

    /*
     * grabar la resolucion de un reclamo en la tabla historial
     * */
    static public function recordHistorial($Arg_params){
        DB::table('historial_arreglos')
          ->insert([
              'motivo'                        => $Arg_params['motivo'],
              'id_deco'                       => $Arg_params['kid'],
              'estado_deco'                   => $Arg_params['estado'],
              'fecha_reclamo'                 => $Arg_params['fecha_reclamo'],
              'fecha_operacion'               => Carbon::now()->toDate(),
              'Localidad'                     => $Arg_params['localidad'],
              'dni_confirmado'                => $Arg_params['dni'],
              'email_confirmado'              => $Arg_params['email'],
              'telefono_confirmado'           => $Arg_params['telefono'],
              'detalles'                      => $Arg_params['observaciones'],
              'cliente_nroabonado'            => $Arg_params['nroabonado'],
              'nombre_apellido_abonado'       => $Arg_params['abonado_nombre_apellido'],
              'id_reclamo'                    => $Arg_params['id_reclamo'],
              'instalador_id'                 => $Arg_params['id_instalador'],
              'nombre_instalador_responsable' => $Arg_params['nombre_instalador'],
          ]);
    }

    /*
     *
     * */
    static public function resolverInstalacion($Arg_params){
        DB::table('instalacion')
          ->insert([
              'fecha_pedido'                  => Carbon::now()->toDate(),
              'nombre'                        => $Arg_params['abonado_nombre_apellido'],
              'dni'                           => $Arg_params['dni'],
              'telefono'                      => $Arg_params['telefono'],
              'email'                         => $Arg_params['email'],
              'calle'                         => $Arg_params['calle'],
              'calle_altura'                  => $Arg_params['calle_altura'],
              'barrio'                        => $Arg_params['barrio'],
              'observaciones'                 => $Arg_params['observaciones'],
              'tipo_servicio'                 => $Arg_params['tipo_servicio'],
              'kid'                           => $Arg_params['kid'],
              'id_reclamo'                    => $Arg_params['id_reclamo'],
              'instalador_id'                 => $Arg_params['id_instalador'],
              'nombre_instalador_responsable' => $Arg_params['nombre_instalador'],
          ]);
    }
}
