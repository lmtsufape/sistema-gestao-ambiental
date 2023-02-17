<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddMotivoSolicitacaoToSolicitacoesPodasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('solicitacoes_podas', function (Blueprint $table) {
            $table->string('motivo_solicitacao')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('solicitacoes_podas', function (Blueprint $table) {
            $table->dropColumn('motivo_solicitacao');
        });
    }
}
