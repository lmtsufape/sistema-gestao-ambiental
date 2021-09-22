<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVisitasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('visitas', function (Blueprint $table) {
            $table->id();
            $table->date('data_marcada');
            $table->date('data_realizada')->nullable();
            
            $table->unsignedBigInteger('requerimento_id')->nullable();
            $table->foreign('requerimento_id')->references('id')->on('requerimentos');
            $table->unsignedBigInteger('denuncia_id')->nullable();
            $table->foreign('denuncia_id')->references('id')->on('denuncias');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('visitas');
    }
}
