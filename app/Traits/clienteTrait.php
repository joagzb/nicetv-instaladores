<?php

namespace App\Traits;

use Illuminate\Support\Facades\DB;

/*===================================================================
 * AQUI HAY FUNCIONES QUE PERMITEN OBTENER INFORMACION ACERCA DE UN
 * CLIENTE DE LA BASE DE DATOS DE LUIS
 * ===================================================================*/

trait clienteTrait
{
    
    /*
    |--------------------------------------------------------------------------
    | CRUD ABONADOS
    |--------------------------------------------------------------------------
    |
    |
    */
    /*
     * obtiene el nro de abonado de un cliente a partir de su DNI
     * */
    protected function getNroAbonado($Arg_dni)
    {
        return DB::connection('original_nicetv')
            ->table('abonado')
            ->where('dni', '=', $Arg_dni)
            ->first('nroabonado');
    }
    
    /*
     * obtener un cliente y sus datos personales
     * */
    protected function getCliente($Arg_nroAbonado)
    {
        return DB::connection('original_nicetv')
            ->table('abonado')
            ->where('abonado.nroabonado', '=', $Arg_nroAbonado)
            ->get([
                'abonado.id',
                'abonado.nroabonado',
                'abonado.nombre',
                'abonado.apellido',
                'abonado.telefono',
                'abonado.mail',
                'abonado.dni',
                'abonado.latitud',
                'abonado.longuitud',
                'abonado.observaciones',
                'abonado.nrocasa',
            ])
            ->first();
        
    }
    
    /*
     * obtener los estados en los que se encuentra un cliente
     * */
    private function API_listEstadoCliente()
    {
        return DB::connection('original_nicetv')
            ->table('estado')
            ->get();
    }
    
    /*
    |--------------------------------------------------------------------------
    | CRUD RECLAMOS
    |--------------------------------------------------------------------------
    |
    |
    */
    /*
     * obtener un listado de los reclamos que aun no han sido atendidos
     * */
    protected function getReclamos($Arg_idtecnico)
    {
        $reclamos = DB::connection('original_nicetv')
            ->table('reclamos')
            ->where('ok', '=', 0)
            ->where('idtecnico', '=', $Arg_idtecnico)
            ->orderByDesc('prioridad')
            ->get([
                'id',
                'idabonado',
                'fechareclamo',
                'prioridad',
            ]);
        foreach ($reclamos as $reclamo) {
            $ciudad_localidad = $this->getLocalidadReclamo($reclamo->idabonado);
            $reclamo->localidad = $ciudad_localidad;
        }
        return $reclamos;
    }
    
    /*
     * obtiene TODOS los reclamos pendientes
     * */
    protected function allReclamos()
    {
        return DB::connection('original_nicetv')
            ->table('reclamos')
            ->where('ok', '=', 0)
            ->join('abonado', 'abonado.nroabonado', '=', 'reclamos.idabonado')
            ->leftJoin('padre', 'abonado.idpadre', '=', 'padre.idpadre')
            ->leftJoin('ciudad', 'padre.idciudad', '=', 'ciudad.idciudad')
            ->select([
                'reclamos.id',
                'reclamos.idabonado',
                'reclamos.fechareclamo',
                'reclamos.prioridad',
                'reclamos.idtecnico',
                'padre.padre',
                'ciudad.ciudad',
            ])
            ->orderBy('fechareclamo')
            ->simplePaginate(5);
    }
    
    /*
     * devuelve la direccion completa de un cliente
     * */
    protected function getLocalidadReclamo($Arg_nroabonado)
    {
        return DB::connection('original_nicetv')
            ->table('abonado')
            ->join('padre', 'padre.idpadre', '=', 'abonado.idpadre')
            ->join('hijo', 'hijo.idhijo', '=', 'abonado.idhijo')
            ->join('nieto', 'nieto.idnieto', '=', 'abonado.idnieto')
            ->join('ciudad', 'ciudad.idciudad', '=', 'padre.idciudad')
            ->where('abonado.nroabonado', '=', $Arg_nroabonado)
            ->get([
                    'padre.padre',
                    'hijo.hijo',
                    'nieto.nieto',
                    'abonado.nrocasa',
                    'abonado.latitud',
                    'abonado.longuitud',
                    'ciudad.ciudad',
                ])
            ->first();
    }
    
    /*
     * obtener informacion completa acerca de una deuda en particular
     * */
    protected function getReclamoDetails($Arg_idreclamo)
    {
        //obtener toda la informacion necesaria de un reclamo
        $reclamo = DB::connection('original_nicetv')
            ->table('reclamos')
            ->join('tipo_reclamo', 'tipo_reclamo.id_t_reclamo', '=', 'reclamos.idtiporeclamo')
            ->join('estado_deco', 'estado_deco.idestado_deco', '=', 'reclamos.idestado_deco')
            ->where('reclamos.id', '=', $Arg_idreclamo)
            ->get([
                'reclamos.id',
                'reclamos.idtecnico',
                'reclamos.idabonado',
                'reclamos.fecha',
                'reclamos.motivo',
                'reclamos.estado',
                'reclamos.fechareclamo',
                'reclamos.ok',
                'reclamos.prioridad',
                'reclamos.deco',
                'reclamos.deco2',
                'reclamos.usuario',
                'reclamos.idtiporeclamo',
                'tipo_reclamo.des_t_reclamo',
                'estado_deco.des_estado',
            ])->first();
        
        if (isset($reclamo)) {
            // anexar los datos del cliente
            $reclamo->cliente_info = $this->getCliente($reclamo->idabonado);
            $reclamo->localidad_cliente = $this->getLocalidadReclamo($reclamo->idabonado);
            return $reclamo;
        } else {
            return NULL;
        }
    }
    
    /*
     * obtener informacion completa acerca de una deuda en particular
     * */
    private function resolver($Arg_idreclamo, $Arg_params)
    {
        DB::connection('original_nicetv')
            ->table('reclamos')
            ->where('id', '=', $Arg_idreclamo)
            ->update([
                'ok' => 1,
                'obs' => $Arg_params['observaciones'],
                'fecha_realizacion' => $Arg_params['fecha_realizacion'],
                'deco' => $Arg_params['deco1'],
                'deco2' => $Arg_params['deco2'],
            ]);
    }
    
    /*
     * enviar una activacion temporal de 48hs
     * TODO: PONER AQUI EL ENVIO DE ACTIVACION DE 48HS
     * */
    private function enviarActivacion()
    {
        return true;
    }
    
    /*
     * obtener el tipo de reclamo
     * */
    private function API_listTipoReclamo()
    {
        return DB::connection('original_nicetv')
            ->table('tipo_reclamo')
            ->get();
    }
    
    /*
    |--------------------------------------------------------------------------
    | CRUD DECOS
    |--------------------------------------------------------------------------
    |
    |
    */
    /*
     * obtener los estados en los que se encuentra un deco
     * */
    private function API_listEstadoDeco()
    {
        return DB::connection('original_nicetv')
            ->table('estado_deco')
            ->get();
    }
    
    
}
