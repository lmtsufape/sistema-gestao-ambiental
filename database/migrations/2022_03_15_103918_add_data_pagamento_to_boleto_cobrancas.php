<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDataPagamentoToBoletoCobrancas extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('boleto_cobrancas', function (Blueprint $table) {
            $table->date('data_pagamento')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('boleto_cobrancas', function (Blueprint $table) {
            $table->dropColumn('data_pagamento');
        });
    }
}
