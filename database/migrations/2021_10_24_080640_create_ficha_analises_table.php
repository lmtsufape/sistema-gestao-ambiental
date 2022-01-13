<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFichaAnalisesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fichas_analises', function (Blueprint $table) {
            $table->id();
            $table->string('condicoes');
            $table->string('localizacao');
            $table->foreignId('solicitacao_poda_id')->constrained('solicitacoes_podas');
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
        Schema::dropIfExists('fichas_analises');
    }
}
