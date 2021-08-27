<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumsEmpresa extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('empresas', function (Blueprint $table) { 
            $table->unsignedBigInteger('cnae_id')->nullable();
            $table->foreign('cnae_id')->references('id')->on('cnaes');
            $table->unsignedBigInteger('represetante_legal_id')->nullable();
            $table->foreign('represetante_legal_id')->references('id')->on('represetante_legals');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
