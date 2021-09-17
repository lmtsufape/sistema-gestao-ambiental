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
            $table->string('caminho_boleto');
            $table->integer('resposta_remessa')->nullable();

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
