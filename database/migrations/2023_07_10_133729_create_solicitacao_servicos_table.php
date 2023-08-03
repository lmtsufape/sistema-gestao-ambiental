<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSolicitacaoServicosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('solicitacao_servicos', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->date('data_solicitacao');
            $table->date('data_saida')->nullable();
            $table->date('data_entrega')->nullable();
            $table->string('motorista');
            $table->string('capacidade_tanque');
            $table->string('nome_apelido')->nullable();
            $table->integer('status')->default(1);
            $table->string('observacao')->nullable();
            
            $table->unsignedBigInteger('beneficiario_id');
            $table->foreign('beneficiario_id')->references('id')->on('beneficiario');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('solicitacao_servicos');
    }
}
