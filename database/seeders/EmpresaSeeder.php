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
            'user_id' => 3,
            'telefone_id' => 2,
            'endereco_id' => 2,
        ]);
    }
}
