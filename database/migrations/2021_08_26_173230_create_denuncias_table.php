<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDenunciasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('denuncias', function (Blueprint $table) {
            $table->id();
            $table->integer('empresa_id')->nullable();
            $table->string('empresa_nao_cadastrada')->nullable();
            $table->string('endereco')->nullable();
            $table->text('texto');
            $table->string('denunciante')->nullable();
            $table->integer('aprovacao')->nullable();
            $table->string('protocolo');

            $table->unsignedBigInteger('analista_id')->nullable();
            $table->foreign('analista_id')->references('id')->on('users');
            
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
        Schema::dropIfExists('denuncias');
    }
}
