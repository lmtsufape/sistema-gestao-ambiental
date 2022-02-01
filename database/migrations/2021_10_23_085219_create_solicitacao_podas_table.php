<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSolicitacaoPodasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('solicitacoes_podas', function (Blueprint $table) {
            $table->id();
            $table->string('protocolo');
            $table->string('motivo_indeferimento')->nullable();
            $table->string('autorizacao_ambiental')->nullable();
            $table->integer('status')->default(1);
            $table->foreignId('analista_id')->nullable()->constrained('users');
            $table->foreignId('endereco_id')->constrained('enderecos');
            $table->foreignId('requerente_id')->constrained('requerentes');
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
        Schema::table('solicitacoes_podas', function (Blueprint $table) {
            $table->dropForeign(['analista_id']);
            $table->dropForeign(['endereco_id']);
            $table->dropForeign(['requerente_id']);
        });
        Schema::dropIfExists('solicitacoes_podas');
    }
}
