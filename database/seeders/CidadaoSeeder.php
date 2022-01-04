<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CidadaoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('cidadaos')->insert([
            'cpf' => '946.445.590-08',
            'rg' => '27.480.662-9',
            'orgao_emissor' => 'SDS-PE',
            'user_id' => 5,
            'telefone_id' => 3,
            'endereco_id' => 3,
        ]);
    }
}
