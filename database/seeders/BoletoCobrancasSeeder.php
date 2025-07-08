<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class BoletoCobrancasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $status = [
            'pago' => 1,
            'nao_pago' => 2,
            'vencido' => 3,
            'cancelado' => 4,
        ];

        for ($i = 0; $i < 30; $i++) {
            DB::table('boleto_cobrancas')->insert([
                'data_vencimento' => Carbon::now()->subDays(rand(0, 60)),
                'caminho_arquivo_remessa' => 'arquivos/remessa_' . Str::random(5) . '.txt',
                'resposta_incluir_boleto' => 'Incluído com sucesso',
                'resposta_alterar_boleto' => 'Alterado',
                'resposta_baixar_boleto' => 'Baixado',
                'resposta_consultar_boleto' => 'Consulta OK',
                'codigo_de_barras' => Str::random(44),
                'linha_digitavel' => Str::random(48),
                'nosso_numero' => rand(10000000, 99999999),
                'URL' => 'https://boleto.fake/' . Str::random(10),
                'status_pagamento' => $status[array_rand($status)],
                'requerimento_id' => rand(1, 2),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
