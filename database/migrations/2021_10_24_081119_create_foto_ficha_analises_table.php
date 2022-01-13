<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFotoFichaAnalisesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fotos_fichas_analises', function (Blueprint $table) {
            $table->id();
            $table->string('caminho');
            $table->string('comentario')->nullable();
            $table->foreignId('ficha_analise_id')->constrained('fichas_analises');
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
        Schema::table('fotos_fichas_analises', function (Blueprint $table) {
            $table->dropForeign(['ficha_analise_id']);
        });
        Schema::dropIfExists('fotos_fichas_analises');
    }
}
