<?php

namespace App\Traits;

/*===================================================================
 * AQUI HAY FUNCIONES QUE PERMITEN OBTENER INFORMACION ACERCA DE UN
 * ADMINISTRADOR
 * ===================================================================*/

use App\Models\admin;
use App\Models\instalador;
use App\Models\preferencia;
use Illuminate\Support\Facades\DB;

trait adminTrait
{
    /*
     * obtener el nivel de administrador del usuario actual
     * */
    protected function getAdmin($id_admin)
    {
        return DB::table('admin')
                 ->join('users', 'users.id', '=', 'admin.id')
                 ->where('admin.id', '=', $id_admin)
                 ->first();
    }

    /*
     * obtener una lista de los administradores del sistema con sus respectivos niveles
     * */
    protected function fetchAdministradores()
    {
        return DB::table('admin')
                 ->join('users', 'users.id', '=', 'admin.id')
                 ->get();
    }

    /*
     * devuelve todos los cobradores y sus cobros recientes (aun no rendidos)
     * */
    protected function fetchInstaladores()
    {
        return DB::table('instalador')
                 ->join('users', 'users.id', '=', 'instalador.id')
                 ->get();
    }

    /*
     * devuelve el perfil completo de un cobrador en particular
     * */
//    private function getCobradorDetails($id_cobrador)
//    {
//        $cobrador = Cobrador::with('deudas')
//                            ->with('locales')
//                            ->join('users', 'users.id', '=', 'cobrador.id')
//                            ->join('direccion_cobrador', 'direccion_cobrador.cobrador_id', '=', 'cobrador.id')
//                            ->find($id_cobrador);
//
//        $cobrador->telefono_cobrador = Cobrador::find($id_cobrador)->telefono;
//
//        foreach ($cobrador->locales->all() as $local) {
//            $val_direccion_localidad = Direccion::with('localidad')
//                                                ->find($local->id);
//            $val_provincia = Provincia::find($val_direccion_localidad->localidad->provincia_id);
//            $local->direccion = $val_direccion_localidad;
//            $local->provincia = $val_provincia;
//        }
//
//        return $cobrador;
//    }

    /*
     * cambiar la comision
     * */
    private function changeComision($comision)
    {
        $admin = admin::getCurrentAdmin();
        preferencia::find(98765)
                   ->setComision($comision, $admin->id, $admin->user->name);
    }
}
