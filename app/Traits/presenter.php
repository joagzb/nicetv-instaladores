<?php

namespace App\Traits;

/*===================================================================
 * AQUI HAY FUNCIONES QUE AYUDAN A PREPARAR LOS DATOS
 * PARA SER PRESENTADOS DE UNA MANERA ENTENDIBLE EN
 * LAS VISTAS
 * ===================================================================*/

use App\Models\historial_arreglos;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

trait presenter
{

    /*
     * devuelve el nombre de un mes a partir de un número entre 1->12
     * */
    static public function getMonthName($numeroMes)
    {
        $nombreMes = "Enero";
        switch ($numeroMes) {
            case 1:
                break;
            case 2:
                $nombreMes = "Febrero";
                break;
            case 3:
                $nombreMes = "Marzo";
                break;
            case 4:
                $nombreMes = "Abril";
                break;
            case 5:
                $nombreMes = "Mayo";
                break;
            case 6:
                $nombreMes = "Junio";
                break;
            case 7:
                $nombreMes = "Julio";
                break;
            case 8:
                $nombreMes = "Agosto";
                break;
            case 9:
                $nombreMes = "Septiembre";
                break;
            case 10:
                $nombreMes = "Octubre";
                break;
            case 11:
                $nombreMes = "Noviembre";
                break;
            case 12:
                $nombreMes = "Diciembre";
                break;
        }
        return $nombreMes;
    }

    /*
     * genera un reporte de todos los usuarios que utilizan la plataforma
     * */
    public function exportHistoricInstalador($desde, $instaladorid)
    {
        //obtener los datos de interes
        $arreglos = DB::select('select * from historial_arreglos where historial_arreglos.instalador_id = :instaladorid and historial_arreglos.fecha_operacion > :desde', [
            'instaladorid' => $instaladorid, 'desde' => $desde,
        ]);

        // nombre del instalador
        $cobrador_name = User::find($instaladorid)->name;

        //obtener la fecha de hoy para saber cuando se genero el archivo
        $fecha_hoy = Carbon::now()
                           ->toDateString();

        //crear un archivo txt para ir ingresando los datos
        $nombre_archivo = "ReclamosAtendidos - " . $cobrador_name . " - " . $desde . " - " . $fecha_hoy . ".csv";
        $file = fopen($nombre_archivo, "w+");
        $relleno = ',';

        //cabecera del archivo (nombre de columnas
        fputs($file, 'Abonado');
        fputs($file, $relleno);
        fputs($file, 'Nombre Apellido');
        fputs($file, $relleno);
        fputs($file, 'fecha de reclamo');
        fputs($file, $relleno);
        fputs($file, 'fecha solucionado');
        fputs($file, $relleno);
        fputs($file, 'localidad');
        fputs($file, $relleno);
        fputs($file, 'motivo');
        fputs($file, $relleno);
        fputs($file, 'detalles');
        fputs($file, $relleno);
        fputs($file, 'decos');
        fputs($file, $relleno);
        fputs($file, 'estado decos');
        fputs($file, $relleno);
        fputs($file, 'DNI informado del cliente');
        fputs($file, $relleno);
        fputs($file, 'EMAIL informado del cliente');
        fputs($file, $relleno);
        fputs($file, 'TELEFONO informado del cliente' . "\n");

        // agregar usuarios al archivo
        foreach ($arreglos as $arreglo) {
            fputs($file, $arreglo->cliente_nroabonado);
            fputs($file, $relleno);
            fputs($file, $arreglo->nombre_apellido_abonado);
            fputs($file, $relleno);
            fputs($file, $arreglo->fecha_reclamo);
            fputs($file, $relleno);
            fputs($file, $arreglo->fecha_operacion);
            fputs($file, $relleno);
            fputs($file, $arreglo->Localidad);
            fputs($file, $relleno);
            fputs($file, preg_replace("/[\r\n|\n|\r]+/", "-", trim($arreglo->motivo)));
            fputs($file, $relleno);
            fputs($file, preg_replace("/[\r\n|\n|\r]+/", "-", trim($arreglo->detalles)));
            fputs($file, $relleno);
            fputs($file, $arreglo->id_deco);
            fputs($file, $relleno);
            fputs($file, $arreglo->estado_deco);
            fputs($file, $relleno);
            fputs($file, $arreglo->dni_confirmado);
            fputs($file, $relleno);
            fputs($file, $arreglo->email_confirmado);
            fputs($file, $relleno);
            fputs($file, $arreglo->telefono_confirmado . "\n");
        }

        //cerrar la escritura sobre el archivo
        fclose($file);

        // recuperamos enlace al archivo para descargarlo
        $archivo = public_path($nombre_archivo);
        $headers = array(
            'Content-Type: Text/csv',
        );

        return [$archivo, $nombre_archivo, $headers];

    }

    /*
     * genera un reporte de todos los usuarios que utilizan la plataforma
     * */
    public function exportHistoricGeneral($desde)
    {
        //obtener los datos de interes
        $fecha_unMesAtras = Carbon::now()
                                  ->subMonth();
        $arreglos = historial_arreglos::all()
                                      ->filter(function($e) use ($fecha_unMesAtras){
                                          return $fecha_unMesAtras->isBefore($e->fecha_operacion);
                                      });

        //obtener la fecha de hoy para saber cuando se genero el archivo
        $fecha_hoy = Carbon::now()
                           ->toDateString();

        //crear un archivo txt para ir ingresando los datos
        $nombre_archivo = "ReclamosAtendidosRecientes - " . $desde . " - " . $fecha_hoy . ".csv";
        $file = fopen($nombre_archivo, "w+");
        $relleno = ',';

        //cabecera del archivo (nombre de columnas
        fputs($file, 'Instalador Responsable');
        fputs($file, $relleno);
        fputs($file, 'Abonado Nro');
        fputs($file, $relleno);
        fputs($file, 'Abonado Nombre');
        fputs($file, $relleno);
        fputs($file, 'fecha de reclamo');
        fputs($file, $relleno);
        fputs($file, 'fecha solucionado');
        fputs($file, $relleno);
        fputs($file, 'localidad');
        fputs($file, $relleno);
        fputs($file, 'motivo');
        fputs($file, $relleno);
        fputs($file, 'detalles');
        fputs($file, $relleno);
        fputs($file, 'decos');
        fputs($file, $relleno);
        fputs($file, 'estado decos');
        fputs($file, $relleno);
        fputs($file, 'DNI informado del cliente');
        fputs($file, $relleno);
        fputs($file, 'EMAIL informado del cliente');
        fputs($file, $relleno);
        fputs($file, 'TELEFONO informado del cliente' . "\n");

        // agregar usuarios al archivo
        foreach ($arreglos as $arreglo) {
            fputs($file, $arreglo->nombre_instalador_responsable);
            fputs($file, $relleno);
            fputs($file, $arreglo->cliente_nroabonado);
            fputs($file, $relleno);
            fputs($file, $arreglo->nombre_apellido_abonado);
            fputs($file, $relleno);
            fputs($file, $arreglo->fecha_reclamo);
            fputs($file, $relleno);
            fputs($file, $arreglo->fecha_operacion);
            fputs($file, $relleno);
            fputs($file, $arreglo->Localidad);
            fputs($file, $relleno);
            fputs($file, preg_replace("/[\r\n|\n|\r]+/", "-", trim($arreglo->motivo)));
            fputs($file, $relleno);
            fputs($file, preg_replace("/[\r\n|\n|\r]+/", "-", trim($arreglo->detalles)));
            fputs($file, $relleno);
            fputs($file, $arreglo->id_deco);
            fputs($file, $relleno);
            fputs($file, $arreglo->estado_deco);
            fputs($file, $relleno);
            fputs($file, $arreglo->dni_confirmado);
            fputs($file, $relleno);
            fputs($file, $arreglo->email_confirmado);
            fputs($file, $relleno);
            fputs($file, $arreglo->telefono_confirmado . "\n");
        }

        //cerrar la escritura sobre el archivo
        fclose($file);

        // recuperamos enlace al archivo para descargarlo
        $archivo = public_path($nombre_archivo);
        $headers = array(
            'Content-Type: Text/csv',
        );

        return [$archivo, $nombre_archivo, $headers];

    }
}
