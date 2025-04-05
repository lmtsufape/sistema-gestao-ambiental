<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFotosAbastecimentosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fotos_abastecimentos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('solicitacao_servico_id')->constrained('solicitacao_servicos')->onDelete('cascade');
            $table->string('assinatura_solicitante');
            $table->string('abastecimento');
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
        Schema::dropIfExists('fotos_abastecimentos');
    }
}
