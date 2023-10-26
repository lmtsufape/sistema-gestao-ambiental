<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterTableBeneficiario extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('beneficiario', function (Blueprint $table) {
            $table->string('cpf')->nullable()->change();
            $table->string('rg')->nullable()->change(); 
            $table->string('orgao_emissor')->nullable()->change();
            $table->string('nis')->nullable()->change();
            $table->string('quantidade_pessoas')->nullable()->change();
            $table->string('observacao')->nullable()->change();
            $table->string('codigo')->nullable()->change();
        });
    }

    public function down()
    {
        Schema::table('beneficiario', function (Blueprint $table) {
            $table->string('cpf')->nullable(false)->change();
            $table->string('rg')->nullable(false)->change(); 
            $table->string('orgao_emissor')->nullable(false)->change();
            $table->string('nis')->nullable(false)->change();
            $table->string('quantidade_pessoas')->nullable(false)->change();
            $table->string('observacao')->nullable(false)->change();
            $table->string('codigo')->nullable(false)->change();
   });
}
}
