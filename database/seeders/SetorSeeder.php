<?php

namespace Database\Seeders;

use App\Models\Setor;
use Illuminate\Database\Seeder;

class SetorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $setores = [
            [
                'nome'           => 'Serviços de Ensino',
                'descricao'      => 'Serviços de educação e ensino nas escolas e instituições',
            ],
            [
                'nome'           => 'Serviços de Saúde/Interesse a saúde/outros',
                'descricao'      => 'Serviços de Saúde/Interesse a saúde/outros',
            ],
            [
                'nome'           => 'Distribuidora de serviços de saúde',
                'descricao'      => 'Distribuidora de serviços de saúde',
            ],
            [
                'nome'           => 'Caminhão pipa',
                'descricao'      => 'Caminhão pipa',
            ],
            [
                'nome'           => 'Estação de tratamento de água',
                'descricao'      => 'Estação de tratamento de água',
            ],
            [
                'nome'           => 'MEI',
                'descricao'      => 'Microempreendedor individual',
            ],
            [
                'nome'           => 'Distribuidora de serviços diversos',
                'descricao'      => 'Distribuidora de serviços diversos',
            ],
            [
                'nome'           => 'MEI/Serviço de alimentação',
                'descricao'      => 'MEI/Serviço de alimentação',
            ],
        ];

        Setor::insert($setores);
    }
}
