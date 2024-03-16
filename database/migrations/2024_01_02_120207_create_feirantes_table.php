<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFeirantesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('feirantes', function (Blueprint $table)
        {
            $table->id();
            $table->string('nome');
            $table->date('data_nascimento');
            $table->string('rg')->unique();
            $table->string('orgao_emissor');
            $table->string('cpf')->unique();
            $table->string('atividade_comercial');
            $table->string('residuos_gerados');
            $table->string('protocolo_vigilancia_sanitaria');

            $table->foreignId('telefone_id')->constrained('telefones');
            $table->foreignId('endereco_residencia_id')->constrained('enderecos');
            $table->foreignId('endereco_comercio_id')->constrained('enderecos');

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
        Schema::dropIfExists('feirantes');
    }
}
