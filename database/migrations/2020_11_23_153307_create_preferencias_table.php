<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePreferenciasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('preferencias', function (Blueprint $table) {
            $table->id();
            $table->float('comision');
            $table->integer('idadmin_ultima_modificacion');
            $table->string('admin_ultima_modificacion');
            $table->timestamps();
        });

        //generar una entrada
        \Illuminate\Support\Facades\DB::table('preferencias')->insert([
            'id'=>98765,
            'comision'=>5,
            'idadmin_ultima_modificacion'=> -1,
            'admin_ultima_modificacion'=> 'dios',
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('preferencias');
    }
}
