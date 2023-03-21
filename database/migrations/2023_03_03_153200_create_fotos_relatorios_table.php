<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFotosRelatoriosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    
    public function up()
    {
        Schema::create('fotos_relatorios', function (Blueprint $table) {
            $table->id();
            $table->string('caminho');
            $table->foreignId('relatorio_id')->constrained('relatorios');
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
        Schema::table('foto_relatorios', function (Blueprint $table) {
            $table->dropForeign(['relatorio_id']);
        });
        Schema::dropIfExists('foto_relatorios');
    }
}
