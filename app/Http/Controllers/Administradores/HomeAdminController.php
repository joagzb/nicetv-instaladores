<?php

namespace App\Http\Controllers\Administradores;

use App\Http\Controllers\Controller;
use App\Models\admin;
use App\Models\historial_arreglos;
use App\Traits\clienteTrait;
use App\Traits\instaladorTrait;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class HomeAdminController extends Controller
{
    /*
     * TRAITS
     * */
    use clienteTrait;
    use instaladorTrait;

    /*
     * VISTA - mostrar pantalla principal con todos los reclamos pendientes
     * */
    public function index(Request $request)
    {
        $reclamos_pendientes = $this->allReclamos()->toArray();

        $fecha_desde = Carbon::now()->subMonths(2);

        $historial = historial_arreglos::all()->filter(function ($e) use ($fecha_desde){
            return  $fecha_desde->isBefore($e->fecha_operacion);
        })->sortBy('fecha_operacion');

        //agregar quien es el instalador responsable
        foreach ($reclamos_pendientes as $reclamo) {
            $tecnico_responsable = $this->getInstalador($reclamo->idtecnico);
            $reclamo->tecnico = $tecnico_responsable;
        }

        // configurar localidad para filtrar por localidad en el frontend
        $localidades_reclamos = array_column($reclamos_pendientes, 'localidad');
        $localidades_reclamos = array_column($localidades_reclamos, 'padre');
        $localidades_reclamos = array_unique($localidades_reclamos);

        return view('administrador.dashboard_admin', [
            'reclamos'    => $reclamos_pendientes,
            'localidades' => $localidades_reclamos,
            'historial_reclamos'=>$historial
        ]);
    }

    /*
     * ver mas detalles acerca de un reclamo pendiente
     * */
    public function verDetalleReclamo(Request $request,$idreclamo){
        $detalle_reclamo = $this->getReclamoDetails($idreclamo);

        // configurar google maps para que puedan ver la ubicacion del abonado
        if (isset($detalle_reclamo->localidad_cliente)) {
            $link_gmaps = 'https://www.google.com/maps/search/?api=1&query=' . $detalle_reclamo->localidad_cliente->latitud . ',' . $detalle_reclamo->localidad_cliente->longuitud . '&zoom=13';
            $detalle_reclamo->link_gmaps = $link_gmaps;
        }

        return view('detalle_reclamo', ['detalle_reclamo' => $detalle_reclamo]);
    }
}
