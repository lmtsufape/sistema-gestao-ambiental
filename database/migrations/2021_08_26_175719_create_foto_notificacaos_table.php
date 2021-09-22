<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFotoNotificacaosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('foto_notificacaos', function (Blueprint $table) {
            $table->id();
            $table->string('caminho');
            $table->text('comentario')->nullable();

            $table->unsignedBigInteger('notificacao_id');
            $table->foreign('notificacao_id')->references('id')->on('notificacaos');

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
        Schema::dropIfExists('foto_notificacaos');
    }
}
