<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCnaesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cnaes', function (Blueprint $table) {
            $table->id();
            $table->string('nome');
            $table->string('codigo');
            $table->double('potencial_poluidor');

            $table->unsignedBigInteger('setor_id');
            $table->foreign('setor_id')->references('id')->on('setors');

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
        Schema::dropIfExists('cnaes');
    }
}
