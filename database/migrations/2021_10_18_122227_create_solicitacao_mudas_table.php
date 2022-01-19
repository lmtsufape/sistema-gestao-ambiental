<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSolicitacaoMudasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('solicitacoes_mudas', function (Blueprint $table) {
            $table->id();
            $table->string('arquivo')->nullable();
            $table->string('comentario')->nullable();
            $table->string('protocolo');
            $table->string('motivo_indeferimento')->nullable();
            $table->integer('status')->default(1);
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
        Schema::dropIfExists('solicitacoes_mudas');
    }
}
