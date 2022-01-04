<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFotoLaudoTecnicosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fotos_laudos_tecnicos', function (Blueprint $table) {
            $table->id();
            $table->string('caminho');
            $table->string('comentario')->nullable();
            $table->foreignId('laudo_tecnico_id')->constrained('laudos_tecnicos');
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
        Schema::table('fotos_laudos_tecnicos', function (Blueprint $table) {
            $table->dropForeign(['laudo_tecnico_id']);
        });
        Schema::dropIfExists('fotos_laudos_tecnicos');
    }
}
