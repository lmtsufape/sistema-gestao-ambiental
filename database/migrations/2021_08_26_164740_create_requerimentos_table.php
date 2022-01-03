<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRequerimentosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('requerimentos', function (Blueprint $table) {
            $table->id();
            $table->integer('status');
            $table->integer('tipo');
            $table->integer('tipo_licenca')->nullable();
            $table->double('valor')->nullable();
            $table->string('definicao_valor')->nullable();
            $table->double('valor_juros')->nullable();

            $table->unsignedBigInteger('analista_id')->nullable();
            $table->foreign('analista_id')->references('id')->on('users');
            $table->unsignedBigInteger('represetante_id')->nullable();
            $table->foreign('represetante_id')->references('id')->on('represetante_legals');
            $table->unsignedBigInteger('empresa_id');
            $table->foreign('empresa_id')->references('id')->on('empresas');

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
        Schema::dropIfExists('requerimentos');
    }
}
