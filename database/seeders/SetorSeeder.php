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
        //ANEXO UNICO
        \App\Models\Setor::create(['nome' =>'Indústrias', 'descricao' => 'Indústrias']);
        \App\Models\Setor::create(['nome' => 'Extração mineral', 'descricao' => 'Extração mineral']);
        \App\Models\Setor::create(['nome' => 'Transporte, tratamento e disposição de resíduos', 'descricao' => 'Transporte, tratamento e disposição de resíduos']);
        \App\Models\Setor::create(['nome' => 'Esgotamento sanitário', 'descricao' => 'Esgotamento sanitário']);
        \App\Models\Setor::create(['nome' => 'Imobiliários', 'descricao' => 'Imobiliários']);
        \App\Models\Setor::create(['nome' => 'Estabelecimentos comerciais e de serviços', 'descricao' => 'Estabelecimentos comerciais e de serviços']);
        \App\Models\Setor::create(['nome' => 'Empreendimentos viários', 'descricao' => 'Empreendimentos viários']);
        \App\Models\Setor::create(['nome' => 'Empreendimentos agropecuários e aquiculturas', 'descricao' => 'Empreendimentos agropecuários e aquiculturas']);
        \App\Models\Setor::create(['nome' => 'Armazenamento e transporte de substâncias perigosas', 'descricao' => 'Armazenamento e transporte de substâncias perigosas']);
        \App\Models\Setor::create(['nome' => 'Obras diversas', 'descricao' => 'Obras diversas']);
        \App\Models\Setor::create(['nome' => 'Utilização de recursos hídricos', 'descricao' => 'Utilização de recursos hídricos']);
        \App\Models\Setor::create(['nome' => 'Energia e telecomunicações', 'descricao' => 'Energia e telecomunicações']);
        \App\Models\Setor::create(['nome' => 'Infraestrutura', 'descricao' => 'Infraestrutura']);
        \App\Models\Setor::create(['nome' => 'Equipamentos de lazer e esportes', 'descricao' => 'Equipamentos de lazer e esportes']);
        \App\Models\Setor::create(['nome' => 'Empreendimentos e atividades florestais', 'descricao' => 'Empreendimentos e atividades florestais']);
    }
}
