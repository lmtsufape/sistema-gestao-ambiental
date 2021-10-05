<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateModificacaoCnaesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('modificacao_cnaes', function (Blueprint $table) {
            $table->id();
            $table->boolean('novo');
            $table->bigInteger('cnae_id');
            $table->foreign('cnae_id')->references('id')->on('cnaes');
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
        Schema::dropIfExists('modificacao_cnaes');
    }
}
