<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class MigrateBeneficiarioEndereco extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $beneficiarios = DB::table('beneficiario')->get();

        foreach ($beneficiarios as $beneficiario) {
            $endereco = DB::table('enderecos')->find($beneficiario->endereco_id);

            if ($endereco) {
                $novoEnderecoId = DB::table('endereco_beneficiarios')->insertGetId([
                    'distrito' => $endereco->distrito ?? null,
                    'comunidade' => $endereco->comunidade ?? null,
                    'cidade' => $endereco->cidade ?? null,
                    'estado' => $endereco->estado ?? null,
                    'numero' => $endereco->numero ?? null,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);

                DB::table('beneficiario')
                    ->where('id', $beneficiario->id)
                    ->update(['endereco_id' => $novoEnderecoId]);
            }
        }

        Schema::table('beneficiario', function (Blueprint $table) {
            $table->dropForeign(['endereco_id']);
        });

        Schema::table('beneficiario', function (Blueprint $table) {
            $table->foreign('endereco_id')->references('id')->on('endereco_beneficiarios');
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
