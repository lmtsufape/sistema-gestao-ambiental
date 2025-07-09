<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RequerimentoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $status = [
            'requerida' => 1,
            'em_andamento' => 2,
            'documentos_requeridos' => 3,
            'documentos_enviados' => 4,
            'documentos_aceitos' => 5,
            'visita_marcada' => 6,
            'visita_realizada' => 7,
            'finalizada' => 8,
            'cancelada' => 9,
        ];

        $tipo = [
            'primeira_licenca' => 1,
            'renovacao' => 2,
            'autorizacao' => 3,
        ];

        for ($i = 0; $i < 30; $i++) {

            DB::table('requerimentos')->insert([
                'status'    => $status[array_rand($status)],
                'tipo'  => $tipo[array_rand($tipo)],
                'valor' => 1234.00,
                'potencial_poluidor_atribuido'  => 0.5,
                'status_empresa'    => 'grande porte',
                'redesim'   => false,
                'empresa_id' => 1,
                'created_at' => now(),
                'updated_at'    =>  now(),
            ]);
        }
    }
}
