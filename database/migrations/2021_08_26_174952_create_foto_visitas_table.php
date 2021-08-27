<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFotoVisitasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('foto_visitas', function (Blueprint $table) {
            $table->id();
            $table->string('caminho');
            $table->text('comentario')->nullable();

            $table->unsignedBigInteger('visita_id');
            $table->foreign('visita_id')->references('id')->on('visitas');

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
        Schema::dropIfExists('foto_visitas');
    }
}
