<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DropMotoristaFromSolicitacaoServicosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('solicitacao_servicos', function (Blueprint $table) {
            $table->dropColumn('motorista');
            $table->dropColumn('capacidade_tanque');
            $table->dropColumn('nome_apelido')->nullable();
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('solicitacao_servicos', function (Blueprint $table) {
            //
        });
    }
}
