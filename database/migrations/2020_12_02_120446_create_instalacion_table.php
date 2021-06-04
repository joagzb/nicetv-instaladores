<?php

use App\Models\instalador;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInstalacionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('instalacion', function (Blueprint $table) {
            $table->id();
            $table->date('fecha_pedido');
            $table->string('nombre_instalador_responsable');
            $table->string('nombre');
            $table->string('dni');
            $table->string('telefono');
            $table->string('email')->nullable();
            $table->string('calle');
            $table->integer('calle_altura');
            $table->string('barrio')->nullable()->default('no especificado');
            $table->string('observaciones')->nullable();
            $table->string('tipo_servicio');
            $table->string('kid');
            $table->integer('id_reclamo');                           //FK de tabla 'reclamos' de la BD de Luis
            $table->foreignIdFor(instalador::class,'instalador_id'); //FK de tabla del modelo 'instalador'
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('instalacion');
    }
}
