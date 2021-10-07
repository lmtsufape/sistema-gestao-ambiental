<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVideoDenunciasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('video_denuncias', function (Blueprint $table) {
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
        Schema::dropIfExists('video_denuncias');
    }
}
