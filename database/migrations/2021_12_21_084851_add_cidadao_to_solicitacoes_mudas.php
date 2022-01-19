<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCidadaoToSolicitacoesMudas extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('solicitacoes_mudas', function (Blueprint $table) {
            $table->foreignId('cidadao_id')->constrained('cidadaos');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('solicitacoes_mudas', function (Blueprint $table) {
            $table->dropForeign(['cidadao_id']);
        });
    }
}
