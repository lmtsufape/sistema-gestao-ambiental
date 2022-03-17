<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMudaSolicitadasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('muda_solicitadas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('solicitacao_id')->nullable();
            $table->foreign('solicitacao_id')->references('id')->on('solicitacoes_mudas');

            $table->unsignedBigInteger('especie_id')->nullable();
            $table->foreign('especie_id')->references('id')->on('especie_mudas');
            
            $table->integer('qtd_mudas')->nullable();
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
        Schema::dropIfExists('muda_solicitadas');
    }
}
