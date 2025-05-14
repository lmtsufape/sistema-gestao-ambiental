<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFotoAracaosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
       Schema::create('foto_aracaos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('aracao_id')->constrained('aracaos')->onDelete('cascade');
            $table->string('caminho');
            $table->string('comentario')->nullable();

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
        Schema::dropIfExists('foto_aracaos');
    }
}
