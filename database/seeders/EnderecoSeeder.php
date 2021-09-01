<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EnderecoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('enderecos')->insert([
            'rua' => 'Rua dos Estados',
            'numero' => '807',
            'bairro' => 'Miranda',
            'cidade' => 'Garanhuns',
            'estado' => 'Pernambuco',
            'complemento' => 'Casa',
            'cep' => '55292-000',
        ]);

        DB::table('enderecos')->insert([
            'rua' => 'Rua do Cateté',
            'numero' => '588',
            'bairro' => 'Jardim Monte Líbano',
            'cidade' => 'Garanhuns',
            'estado' => 'Pernambuco',
            'complemento' => 'Casa',
            'cep' => '55292-000',
        ]);
    }
}
