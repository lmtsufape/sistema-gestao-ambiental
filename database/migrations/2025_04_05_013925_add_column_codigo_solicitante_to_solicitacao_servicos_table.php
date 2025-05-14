<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnCodigoSolicitanteToSolicitacaoServicosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('solicitacao_servicos', function (Blueprint $table) {
            $table->string('codigo_solicitante')->nullable();
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
            $table->dropColumn('codigo_solicitante');
        });
    }
}
