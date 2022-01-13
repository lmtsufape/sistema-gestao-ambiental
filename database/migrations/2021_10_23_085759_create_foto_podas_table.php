<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFotoPodasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fotos_podas', function (Blueprint $table) {
            $table->id();
            $table->string('caminho');
            $table->string('comentario')->nullable();
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
        Schema::table('fotos_podas', function (Blueprint $table) {
            $table->dropForeign(['solicitacao_poda_id']);
        });
        Schema::dropIfExists('fotos_podas');
    }
}
