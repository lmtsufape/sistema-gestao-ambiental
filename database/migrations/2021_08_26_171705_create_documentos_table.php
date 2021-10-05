<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDocumentosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('documentos', function (Blueprint $table) {
            $table->id();
            $table->string('nome', 290);
            $table->string('documento_modelo')->nullable();
            $table->boolean('padrao_previa')->dafault(false)->nullable();
            $table->boolean('padrao_instalacao')->dafault(false)->nullable();
            $table->boolean('padrao_operacao')->dafault(false)->nullable();
            $table->boolean('padrao_simplificada')->dafault(false)->nullable();
            $table->boolean('padrao_autorizacao_ambiental')->dafault(false)->nullable();
            $table->boolean('padrao_regularizacao')->dafault(false)->nullable();
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
        Schema::dropIfExists('documentos');
    }
}
