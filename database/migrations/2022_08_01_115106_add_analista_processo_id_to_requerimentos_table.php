<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAnalistaProcessoIdToRequerimentosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('requerimentos', function (Blueprint $table) {
            $table->foreignId('analista_processo_id')->nullable()->references('id')->on('users');;
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('requerimentos', function (Blueprint $table) {
            $table->dropColumn('analista_processo_id');
        });
    }
}
