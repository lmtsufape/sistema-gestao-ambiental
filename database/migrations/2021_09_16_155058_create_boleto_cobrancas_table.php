<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBoletoCobrancasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('boleto_cobrancas', function (Blueprint $table) {
            $table->id();
            $table->date('data_vencimento');
            $table->string('caminho_arquivo_remessa')->nullable();
            $table->string('resposta_incluir_boleto')->nullable();
            $table->string('resposta_aleterar_boleto')->nullable();
            $table->string('resposta_baixar_boleto')->nullable();
            $table->string('resposta_consultar_boleto')->nullable();
            $table->string('codigo_de_barras')->nullable();
            $table->string('linha_digitavel')->nullable();
            $table->string('nosso_numero')->nullable(); 
            $table->string('URL')->nullable();

            $table->integer('status_pagamento')->nullable();

            $table->bigInteger('requerimento_id');
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
        Schema::dropIfExists('boleto_cobrancas');
    }
}
