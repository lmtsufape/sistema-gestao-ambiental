<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCidadaosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cidadaos', function (Blueprint $table) {
            $table->id();
            $table->string('cpf');
            $table->string('rg');
            $table->string('orgao_emissor');
            $table->foreignId('user_id')->constrained('users');
            $table->foreignId('endereco_id')->constrained('enderecos');
            $table->foreignId('telefone_id')->constrained('telefones');
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
        Schema::table('cidadaos', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropForeign(['endereco_id']);
            $table->dropForeign(['telefone_id']);
        });
        Schema::dropIfExists('cidadaos');
    }
}
