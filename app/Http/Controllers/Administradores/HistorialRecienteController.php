<?php

namespace App\Http\Controllers\Administradores;

use App\Http\Controllers\Controller;
use App\Models\admin;
use App\Models\historial_arreglos;
use App\Models\instalador;
use App\Traits\clienteTrait;
use App\Traits\instaladorTrait;
use App\Traits\presenter;
use App\Traits\reclamoTrait;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HistorialRecienteController extends Controller
{
    /*
     * TRAIT
     * */
    use presenter;
    use reclamoTrait;

    /*
     * DESCARGA DE ARCHIVO - exportar el historial de reclamos atendidos en formato .csv
     * */
    public function exportHistorialReciente(Request $request)
    {
        $fecha_desde = $request->input('fecha_desde');
        $arreglo_archivo = $this->exportHistoricGeneral($fecha_desde);

        return response()
            ->download($arreglo_archivo[0], $arreglo_archivo[1], $arreglo_archivo[2])
            ->deleteFileAfterSend();
    }

    /*
     * VISTA - muestra mas detalles sobre un reclamo resuelto
     * */
    public function verDetalleReclamo(Request $request,$Arg_idreclamo)
    {
        $detalle_reclamo = historial_arreglos::all()
                                             ->where('id_reclamo', '=', $Arg_idreclamo)->first();

        if(isset($detalle_reclamo->localidad_cliente)){
            $link_gmaps = 'https://www.google.com/maps/search/?api=1&query=' . $detalle_reclamo->localidad_cliente->latitud . ',' . $detalle_reclamo->localidad_cliente->longuitud . '&zoom=13';
            $detalle_reclamo->link_gmaps = $link_gmaps;
        }

        return view('detalle_reclamo_historial', ['detalle_reclamo' => $detalle_reclamo]);
    }
}
