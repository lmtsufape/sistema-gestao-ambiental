<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RequerenteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('requerentes')->insert([
            'cpf' => '872.117.185-87',
            'rg' => '38.291.584-7',
            'orgao_emissor' => 'SDS-PE',
            'user_id' => 3,
            'telefone_id' => 1,
            'endereco_id' => 1,
        ]);
    }
}
