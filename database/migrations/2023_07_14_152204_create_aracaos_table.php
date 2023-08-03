<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAracaosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('aracaos', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->unsignedBigInteger('beneficiario_id');
            $table->foreign('beneficiario_id')->references('id')->on('beneficiario');
            $table->string('cultura');
            $table->string('ponto_localizacao');
            $table->string('quantidade_ha');
            $table->string('quantidade_horas');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('aracaos');
    }
}
