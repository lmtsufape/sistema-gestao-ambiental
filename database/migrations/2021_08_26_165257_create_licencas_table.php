<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLicencasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('licencas', function (Blueprint $table) {
            $table->id();
            $table->string('protocolo')->nullable();
            $table->integer('status');
            $table->integer('tipo');
            $table->double('valor');
            $table->string('validade');

            $table->unsignedBigInteger('requerimento_id');
            $table->foreign('requerimento_id')->references('id')->on('requerimentos');

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
        Schema::dropIfExists('licencas');
    }
}
