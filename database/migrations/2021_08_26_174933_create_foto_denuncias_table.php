<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFotoDenunciasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('foto_denuncias', function (Blueprint $table) {
            $table->id();
            $table->string('caminho');
            $table->text('comentario')->nullable();

            $table->unsignedBigInteger('denuncia_id');
            $table->foreign('denuncia_id')->references('id')->on('denuncias');
            
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
        Schema::dropIfExists('foto_denuncias');
    }
}
