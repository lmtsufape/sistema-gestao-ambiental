<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRequerimentosDocumentosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('requerimentos_documentos', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->unsignedBigInteger('requerimento_id');
            $table->foreign('requerimento_id')->references('id')->on('requerimentos');
            $table->unsignedBigInteger('documento_id')->nullable();
            $table->foreign('documento_id')->references('id')->on('documentos');
            $table->unsignedBigInteger('empresa_id')->nullable();
            $table->foreign('empresa_id')->references('id')->on('empresas');
            $table->string('arquivo_outro_documento')->nullable();
            $table->string('nome_outro_documento')->nullable();
            $table->text('comentario_outro_documento')->nullable();
            $table->date('prazo_exigencia')->nullable();
            $table->string('anexo_arquivo')->nullable();
            $table->text('comentario_anexo')->nullable();
            $table->integer('status')->default(1);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('requerimentos_documentos');
    }
}
