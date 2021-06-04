<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHistorialArreglosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('historial_arreglos', function (Blueprint $table) {
            $table->id();
            $table->string('motivo',100);
            $table->string('id_deco',30);
            $table->string('estado_deco',30)->nullable();
            $table->timestamp('fecha_reclamo');
            $table->date('fecha_operacion');
            $table->string('Localidad',100);
            $table->string('dni_confirmado',16);
            $table->string('email_confirmado',100)->default('no_especifica@gmail.com');
            $table->string('telefono_confirmado',20);
            $table->string('detalles',200)->nullable();
            $table->string('nombre_apellido_abonado',100);
            $table->integer('cliente_nroabonado'); //FK de tabla 'abonado' de la BD de Luis
            $table->integer('id_reclamo'); //FK de tabla 'reclamos' de la BD de Luis
            $table->foreignIdFor(\App\Models\instalador::class,'instalador_id');
            $table->string('nombre_instalador_responsable');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('historial_arreglos');
    }
}
