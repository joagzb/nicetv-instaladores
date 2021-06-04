<?php

namespace App\Http\Controllers\Instaladores;

use App\Http\Controllers\Controller;
use App\Models\instalador;
use App\Traits\clienteTrait;
use App\Traits\presenter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class HistorialReclamoController extends Controller
{
    /*
     * TRAITS
     * */
    use presenter;
    use clienteTrait;

    /*
     * VISTA - mostrar un listado con el historial de reclamos atendidos
     * */
    public function index()
    {
        $instalador = instalador::find(Auth::user()->id);
        $historial_reclamos = $instalador->getCurrentHistorial();

        return view('historial_reclamos_resueltos', ['historial_reclamos' => $historial_reclamos]);
    }

    /*
     * VISTA - mostrar mas detalles sobre un reclamo
     * */
    public function detalleReclamo(Request $request, $Arg_idreclamo)
    {
        $idreclamo = decrypt($Arg_idreclamo);
        $instalador = instalador::getCurrentInstalador();
        $detalle_reclamo = $instalador->getDetalleReclamoHistorial($idreclamo);

        return view('detalle_reclamo_historial', ['detalle_reclamo' => $detalle_reclamo]);
    }

    /*
     * DESCARGA DE ARCHIVO - exportar el historial de reclamos atendidos en formato .csv
     * */
    public function exportHistorial(Request $request)
    {
        $fecha_desde = $request->input('fecha_desde');
        $arreglo_archivo = $this->exportHistoricInstalador($fecha_desde, Auth::user()->id);

        return response()
            ->download($arreglo_archivo[0], $arreglo_archivo[1], $arreglo_archivo[2])
            ->deleteFileAfterSend();
    }
}
