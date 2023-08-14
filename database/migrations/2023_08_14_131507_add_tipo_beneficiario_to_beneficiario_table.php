<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTipoBeneficiarioToBeneficiarioTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('beneficiario', function (Blueprint $table) {
            $table->integer('tipo_beneficiario');
            $table->string('codigo');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('beneficiario', function (Blueprint $table) {
            $table->dropColumn('tipo_beneficiario');
            $table->dropColumn('codigo');
        });
    }
}
