<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateModificacaoPortesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('modificacao_portes', function (Blueprint $table) {
            $table->id();
            $table->integer('porte_antigo');
            $table->integer('porte_atual');
            $table->bigInteger('historico_id');
            $table->foreign('historico_id')->references('id')->on('historicos');
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
        Schema::dropIfExists('modificacao_portes');
    }
}
