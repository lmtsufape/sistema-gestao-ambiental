<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAutorToNotificacaos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('notificacaos', function (Blueprint $table) {
            $table->foreignId('autor_id')->nullable()->constrained('users');
            $table->boolean('visto')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('notificacaos', function (Blueprint $table) {
            $table->dropForeign(['autor_id']);
            $table->dropColumn(['autor_id', 'visto']);
        });
    }
}
