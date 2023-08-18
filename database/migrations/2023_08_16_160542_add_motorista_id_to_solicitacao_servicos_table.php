<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddMotoristaIdToSolicitacaoServicosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('solicitacao_servicos', function (Blueprint $table) {
            $table->unsignedBigInteger('motorista_id')->nullable();
            $table->foreign('motorista_id')->references('id')->on('motorista');
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
