<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAnexoRequerimentosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('anexo_requerimentos', function (Blueprint $table) {
            $table->id();
            $table->string('caminho');
            $table->text('comentario')->nullable();
            $table->integer('status');

            $table->unsignedBigInteger('requerimento_id');
            $table->foreign('requerimento_id')->references('id')->on('requerimentos');
            $table->unsignedBigInteger('documento_id');
            $table->foreign('documento_id')->references('id')->on('documentos');

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
        Schema::dropIfExists('anexo_requerimentos');
    }
}
