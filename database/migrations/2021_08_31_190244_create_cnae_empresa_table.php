<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCnaeEmpresaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cnae_empresa', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('cnae_id');
            $table->foreign('cnae_id')->references('id')->on('cnaes');
            $table->bigInteger('empresa_id');
            $table->foreign('empresa_id')->references('id')->on('empresas');
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
        Schema::dropIfExists('cnae_empresa');
    }
}
