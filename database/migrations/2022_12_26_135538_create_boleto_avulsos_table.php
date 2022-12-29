<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBoletoAvulsosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('boleto_avulsos', function (Blueprint $table) {
            $table->id();

            $table->date('data_vencimento');
            $table->date('data_pagamento')->nullable();
            $table->double('valor_boleto')->nullable();
            $table->string('caminho_arquivo_remessa')->nullable();
            $table->string('resposta_incluir_boleto')->nullable();
            $table->string('resposta_alterar_boleto')->nullable();
            $table->string('resposta_baixar_boleto')->nullable();
            $table->string('resposta_consultar_boleto')->nullable();
            $table->string('codigo_de_barras')->nullable();
            $table->string('linha_digitavel')->nullable();
            $table->string('nosso_numero')->nullable(); 
            $table->string('URL')->nullable();

            $table->integer('status_pagamento')->nullable();

            $table->bigInteger('empresa_id');
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
        Schema::dropIfExists('boleto_avulsos');
    }
}
