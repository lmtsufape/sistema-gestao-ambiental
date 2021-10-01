<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EmpresaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('empresas')->insert([
            'nome' => 'Info mundo tecnologia',
            'cnpj' => '32.970.478/0001-30',
            'porte' => 1,
            'user_id' => 4,
            'telefone_id' => 2,
            'endereco_id' => 2,
        ]);

        DB::table('cnae_empresa')->insert([
            'cnae_id' => 1,
            'empresa_id' => 1,
        ]);

        DB::table('cnae_empresa')->insert([
            'cnae_id' => 2,
            'empresa_id' => 1,
        ]);
    }
}
