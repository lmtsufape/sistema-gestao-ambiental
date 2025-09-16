<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAtividadeToLaudosTecnicosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('laudos_tecnicos', function (Blueprint $table) {
            $table->tinyInteger('atividade')
                   ->after('licenca')
                   ->default(3);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('laudos_tecnicos', function (Blueprint $table) {
            //
        });
    }
}
