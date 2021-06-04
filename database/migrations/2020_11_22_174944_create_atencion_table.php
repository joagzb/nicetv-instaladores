<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAtencionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('atencion', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('motivo',30);
            $table->timestamp('fecha_reclamo');
            $table->bigInteger('fk_nroabonado'); //FK de tabla 'reclamos' de la BD de Luis
            $table->bigInteger('fk_idreclamos'); //FK de tabla 'reclamos' de la BD de Luis
            $table->foreignIdFor(\App\Models\instalador::class,'instalador_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('atencion');
    }
}
