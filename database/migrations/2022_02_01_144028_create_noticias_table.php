<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNoticiasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('noticias', function (Blueprint $table) {
            $table->id();
            $table->string('imagem_principal')->nullable(true);
            $table->string('titulo');
            $table->longText('texto');
            $table->string('link');
            $table->boolean('publicada')->default(false);
            $table->boolean('destaque')->default(false);
            $table->unsignedBigInteger('autor_id');
            $table->timestamps();

            $table->foreign('autor_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('noticias');
    }
}
