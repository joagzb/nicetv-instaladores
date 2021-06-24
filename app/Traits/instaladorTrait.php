<?php

namespace App\Traits;

use App\Models\Atencion;
use App\Models\historial_arreglos;
use App\Models\instalador;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

/*===================================================================
 * AQUI HAY FUNCIONES QUE PERMITEN OBTENER INFORMACION ACERCA DE UN
 * INSTALADOR
 * ===================================================================*/

trait instaladorTrait
{
    /*
     * obtener un instaldor y sus datos
     * */
    private function getInstalador($id_instalador)
    {
        $usuario = DB::table('users')
                     ->where('id', '=', $id_instalador)
                     ->first();
        $instalador = instalador::all()
                                ->find($id_instalador);
        if ($instalador == null || $instalador == [] || empty($instalador)) {
            return null;
        }
        $instalador->usuario = $usuario;
        return $instalador;
    }

    /*
     * obtener los reclamos que un instalador ha guardado
     * todo: no se si esta tabla se va usar
     * */
    private function getAtenciones($id_instalador)
    {
        return Atencion::all()
                       ->where('instalador_id', '=', $id_instalador);
    }

    /*
     * obtener una lista de todos los reclamos que ha atendido el instalador
     * */
    private function getHistorialInstalador($id_instalador)
    {
        return historial_arreglos::all()
                                 ->where('instalador_id', '=', $id_instalador);
    }

    /*
     * obtener un reclamo en particular y sus detalles
     * */
    private function getDetalleHistorial($id_instalador, $idreclamo)
    {
        return historial_arreglos::all()
                                 ->where('instalador_id', '=', $id_instalador)
                                 ->where('id', '=', $idreclamo)
                                 ->first();
    }

    /*
     * evalúa si el instalador actual se encuentra habilitado. No podrá atender ningun
     * reclamo si esta deshabilitado
     * */
    private function isHabilitado($id_instalador): bool
    {
        $instalador = $this->getInstalador($id_instalador);
        return $instalador->habilitado == 1;
    }

    /*
     * obtiene los instaladores registrados en la base de datos de luis
     * */
    private function API_fetchInstaladores()
    {
        return DB::connection('original_nicetv')
                 ->table('tecnico')
                 ->get();
    }

    /*
     * obtiene los datos detallados acerca de un usuario tecnico de la base de datos de luis
     * */
    private function API_fullTecnicoDetail($id)
    {
        return DB::connection('original_nicetv')
                 ->table('tecnico')
                 ->where('id', '=', $id)
                 ->first();
    }
}
