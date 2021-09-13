<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ValorRequerimento;

class ValoresSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $valores = [
            [
                'porte' => ValorRequerimento::PORTE_ENUM['micro'],
                'potencial_poluidor' => ValorRequerimento::POTENCIAL_POLUIDOR_ENUM['baixo'],
                'tipo_de_licenca' => ValorRequerimento::TIPO_LICENCA_ENUM['simplificada'],
                'valor' => 50.00,
            ],
            [
                'porte' => ValorRequerimento::PORTE_ENUM['micro'],
                'potencial_poluidor' => ValorRequerimento::POTENCIAL_POLUIDOR_ENUM['medio'],
                'tipo_de_licenca' => ValorRequerimento::TIPO_LICENCA_ENUM['simplificada'],
                'valor' => 75.00,
            ],
            [
                'porte' => ValorRequerimento::PORTE_ENUM['micro'],
                'potencial_poluidor' => ValorRequerimento::POTENCIAL_POLUIDOR_ENUM['alto'],
                'tipo_de_licenca' => ValorRequerimento::TIPO_LICENCA_ENUM['simplificada'],
                'valor' => 100.00,
            ],
            [
                'porte' => ValorRequerimento::PORTE_ENUM['micro'],
                'potencial_poluidor' => ValorRequerimento::POTENCIAL_POLUIDOR_ENUM['baixo'],
                'tipo_de_licenca' => ValorRequerimento::TIPO_LICENCA_ENUM['previa'],
                'valor' => 50.00,
            ],
            [
                'porte' => ValorRequerimento::PORTE_ENUM['micro'],
                'potencial_poluidor' => ValorRequerimento::POTENCIAL_POLUIDOR_ENUM['medio'],
                'tipo_de_licenca' => ValorRequerimento::TIPO_LICENCA_ENUM['previa'],
                'valor' => 75.00,
            ],
            [
                'porte' => ValorRequerimento::PORTE_ENUM['micro'],
                'potencial_poluidor' => ValorRequerimento::POTENCIAL_POLUIDOR_ENUM['alto'],
                'tipo_de_licenca' => ValorRequerimento::TIPO_LICENCA_ENUM['previa'],
                'valor' => 50.00,
            ],
            [
                'porte' => ValorRequerimento::PORTE_ENUM['micro'],
                'potencial_poluidor' => ValorRequerimento::POTENCIAL_POLUIDOR_ENUM['baixo'],
                'tipo_de_licenca' => ValorRequerimento::TIPO_LICENCA_ENUM['instalacao'],
                'valor' => 50.00,
            ],
            [
                'porte' => ValorRequerimento::PORTE_ENUM['micro'],
                'potencial_poluidor' => ValorRequerimento::POTENCIAL_POLUIDOR_ENUM['medio'],
                'tipo_de_licenca' => ValorRequerimento::TIPO_LICENCA_ENUM['instalacao'],
                'valor' => 75.00,
            ],
            [
                'porte' => ValorRequerimento::PORTE_ENUM['micro'],
                'potencial_poluidor' => ValorRequerimento::POTENCIAL_POLUIDOR_ENUM['alto'],
                'tipo_de_licenca' => ValorRequerimento::TIPO_LICENCA_ENUM['instalacao'],
                'valor' => 100.00,
            ],
            [
                'porte' => ValorRequerimento::PORTE_ENUM['micro'],
                'potencial_poluidor' => ValorRequerimento::POTENCIAL_POLUIDOR_ENUM['baixo'],
                'tipo_de_licenca' => ValorRequerimento::TIPO_LICENCA_ENUM['operacao'],
                'valor' => 50.00,
            ],
            [
                'porte' => ValorRequerimento::PORTE_ENUM['micro'],
                'potencial_poluidor' => ValorRequerimento::POTENCIAL_POLUIDOR_ENUM['medio'],
                'tipo_de_licenca' => ValorRequerimento::TIPO_LICENCA_ENUM['operacao'],
                'valor' => 75.00,
            ],
            [
                'porte' => ValorRequerimento::PORTE_ENUM['micro'],
                'potencial_poluidor' => ValorRequerimento::POTENCIAL_POLUIDOR_ENUM['alto'],
                'tipo_de_licenca' => ValorRequerimento::TIPO_LICENCA_ENUM['operacao'],
                'valor' => 75.00,
            ],
            [
                'porte' => ValorRequerimento::PORTE_ENUM['pequeno'],
                'potencial_poluidor' => ValorRequerimento::POTENCIAL_POLUIDOR_ENUM['baixo'],
                'tipo_de_licenca' => ValorRequerimento::TIPO_LICENCA_ENUM['simplificada'],
                'valor' => 100.00,
            ],
            [
                'porte' => ValorRequerimento::PORTE_ENUM['pequeno'],
                'potencial_poluidor' => ValorRequerimento::POTENCIAL_POLUIDOR_ENUM['medio'],
                'tipo_de_licenca' => ValorRequerimento::TIPO_LICENCA_ENUM['simplificada'],
                'valor' => 100.00,
            ],
            [
                'porte' => ValorRequerimento::PORTE_ENUM['pequeno'],
                'potencial_poluidor' => ValorRequerimento::POTENCIAL_POLUIDOR_ENUM['alto'],
                'tipo_de_licenca' => ValorRequerimento::TIPO_LICENCA_ENUM['simplificada'],
                'valor' => 100.00,
            ],
            [
                'porte' => ValorRequerimento::PORTE_ENUM['pequeno'],
                'potencial_poluidor' => ValorRequerimento::POTENCIAL_POLUIDOR_ENUM['baixo'],
                'tipo_de_licenca' => ValorRequerimento::TIPO_LICENCA_ENUM['previa'],
                'valor' => 100.00,
            ],
            [
                'porte' => ValorRequerimento::PORTE_ENUM['pequeno'],
                'potencial_poluidor' => ValorRequerimento::POTENCIAL_POLUIDOR_ENUM['medio'],
                'tipo_de_licenca' => ValorRequerimento::TIPO_LICENCA_ENUM['previa'],
                'valor' => 140.00,
            ],
            [
                'porte' => ValorRequerimento::PORTE_ENUM['pequeno'],
                'potencial_poluidor' => ValorRequerimento::POTENCIAL_POLUIDOR_ENUM['alto'],
                'tipo_de_licenca' => ValorRequerimento::TIPO_LICENCA_ENUM['previa'],
                'valor' => 190.00,
            ],
            [
                'porte' => ValorRequerimento::PORTE_ENUM['pequeno'],
                'potencial_poluidor' => ValorRequerimento::POTENCIAL_POLUIDOR_ENUM['baixo'],
                'tipo_de_licenca' => ValorRequerimento::TIPO_LICENCA_ENUM['instalacao'],
                'valor' => 100.00,
            ],
            [
                'porte' => ValorRequerimento::PORTE_ENUM['pequeno'],
                'potencial_poluidor' => ValorRequerimento::POTENCIAL_POLUIDOR_ENUM['medio'],
                'tipo_de_licenca' => ValorRequerimento::TIPO_LICENCA_ENUM['instalacao'],
                'valor' => 280.00,
            ],
            [
                'porte' => ValorRequerimento::PORTE_ENUM['pequeno'],
                'potencial_poluidor' => ValorRequerimento::POTENCIAL_POLUIDOR_ENUM['alto'],
                'tipo_de_licenca' => ValorRequerimento::TIPO_LICENCA_ENUM['instalacao'],
                'valor' => 380.00,
            ],
            [
                'porte' => ValorRequerimento::PORTE_ENUM['pequeno'],
                'potencial_poluidor' => ValorRequerimento::POTENCIAL_POLUIDOR_ENUM['baixo'],
                'tipo_de_licenca' => ValorRequerimento::TIPO_LICENCA_ENUM['operacao'],
                'valor' => 100.00,
            ],
            [
                'porte' => ValorRequerimento::PORTE_ENUM['pequeno'],
                'potencial_poluidor' => ValorRequerimento::POTENCIAL_POLUIDOR_ENUM['medio'],
                'tipo_de_licenca' => ValorRequerimento::TIPO_LICENCA_ENUM['operacao'],
                'valor' => 215.00,
            ],
            [
                'porte' => ValorRequerimento::PORTE_ENUM['pequeno'],
                'potencial_poluidor' => ValorRequerimento::POTENCIAL_POLUIDOR_ENUM['alto'],
                'tipo_de_licenca' => ValorRequerimento::TIPO_LICENCA_ENUM['operacao'],
                'valor' => 280.00,
            ],
            [
                'porte' => ValorRequerimento::PORTE_ENUM['medio'],
                'potencial_poluidor' => ValorRequerimento::POTENCIAL_POLUIDOR_ENUM['baixo'],
                'tipo_de_licenca' => ValorRequerimento::TIPO_LICENCA_ENUM['simplificada'],
                'valor' => 100.00,
            ],
            [
                'porte' => ValorRequerimento::PORTE_ENUM['medio'],
                'potencial_poluidor' => ValorRequerimento::POTENCIAL_POLUIDOR_ENUM['medio'],
                'tipo_de_licenca' => ValorRequerimento::TIPO_LICENCA_ENUM['simplificada'],
                'valor' => 100.00,
            ],
            [
                'porte' => ValorRequerimento::PORTE_ENUM['medio'],
                'potencial_poluidor' => ValorRequerimento::POTENCIAL_POLUIDOR_ENUM['alto'],
                'tipo_de_licenca' => ValorRequerimento::TIPO_LICENCA_ENUM['simplificada'],
                'valor' => 100.00,
            ],
            [
                'porte' => ValorRequerimento::PORTE_ENUM['medio'],
                'potencial_poluidor' => ValorRequerimento::POTENCIAL_POLUIDOR_ENUM['baixo'],
                'tipo_de_licenca' => ValorRequerimento::TIPO_LICENCA_ENUM['previa'],
                'valor' => 250.00,
            ],
            [
                'porte' => ValorRequerimento::PORTE_ENUM['medio'],
                'potencial_poluidor' => ValorRequerimento::POTENCIAL_POLUIDOR_ENUM['medio'],
                'tipo_de_licenca' => ValorRequerimento::TIPO_LICENCA_ENUM['previa'],
                'valor' => 330.00,
            ],
            [
                'porte' => ValorRequerimento::PORTE_ENUM['medio'],
                'potencial_poluidor' => ValorRequerimento::POTENCIAL_POLUIDOR_ENUM['alto'],
                'tipo_de_licenca' => ValorRequerimento::TIPO_LICENCA_ENUM['previa'],
                'valor' => 440.00,
            ],
            [
                'porte' => ValorRequerimento::PORTE_ENUM['medio'],
                'potencial_poluidor' => ValorRequerimento::POTENCIAL_POLUIDOR_ENUM['baixo'],
                'tipo_de_licenca' => ValorRequerimento::TIPO_LICENCA_ENUM['instalacao'],
                'valor' => 500.00,
            ],
            [
                'porte' => ValorRequerimento::PORTE_ENUM['medio'],
                'potencial_poluidor' => ValorRequerimento::POTENCIAL_POLUIDOR_ENUM['medio'],
                'tipo_de_licenca' => ValorRequerimento::TIPO_LICENCA_ENUM['instalacao'],
                'valor' => 660.00,
            ],
            [
                'porte' => ValorRequerimento::PORTE_ENUM['medio'],
                'potencial_poluidor' => ValorRequerimento::POTENCIAL_POLUIDOR_ENUM['alto'],
                'tipo_de_licenca' => ValorRequerimento::TIPO_LICENCA_ENUM['instalacao'],
                'valor' => 880.00,
            ],
            [
                'porte' => ValorRequerimento::PORTE_ENUM['medio'],
                'potencial_poluidor' => ValorRequerimento::POTENCIAL_POLUIDOR_ENUM['baixo'],
                'tipo_de_licenca' => ValorRequerimento::TIPO_LICENCA_ENUM['operacao'],
                'valor' => 380.00,
            ],
            [
                'porte' => ValorRequerimento::PORTE_ENUM['medio'],
                'potencial_poluidor' => ValorRequerimento::POTENCIAL_POLUIDOR_ENUM['medio'],
                'tipo_de_licenca' => ValorRequerimento::TIPO_LICENCA_ENUM['operacao'],
                'valor' => 500.00,
            ],
            [
                'porte' => ValorRequerimento::PORTE_ENUM['medio'],
                'potencial_poluidor' => ValorRequerimento::POTENCIAL_POLUIDOR_ENUM['alto'],
                'tipo_de_licenca' => ValorRequerimento::TIPO_LICENCA_ENUM['operacao'],
                'valor' => 660.00,
            ],
            [
                'porte' => ValorRequerimento::PORTE_ENUM['grande'],
                'potencial_poluidor' => ValorRequerimento::POTENCIAL_POLUIDOR_ENUM['baixo'],
                'tipo_de_licenca' => ValorRequerimento::TIPO_LICENCA_ENUM['simplificada'],
                'valor' => 100.00,
            ],
            [
                'porte' => ValorRequerimento::PORTE_ENUM['grande'],
                'potencial_poluidor' => ValorRequerimento::POTENCIAL_POLUIDOR_ENUM['medio'],
                'tipo_de_licenca' => ValorRequerimento::TIPO_LICENCA_ENUM['simplificada'],
                'valor' => 100.00,
            ],
            [
                'porte' => ValorRequerimento::PORTE_ENUM['grande'],
                'potencial_poluidor' => ValorRequerimento::POTENCIAL_POLUIDOR_ENUM['alto'],
                'tipo_de_licenca' => ValorRequerimento::TIPO_LICENCA_ENUM['simplificada'],
                'valor' => 100.00,
            ],
            [
                'porte' => ValorRequerimento::PORTE_ENUM['grande'],
                'potencial_poluidor' => ValorRequerimento::POTENCIAL_POLUIDOR_ENUM['baixo'],
                'tipo_de_licenca' => ValorRequerimento::TIPO_LICENCA_ENUM['previa'],
                'valor' => 590.00,
            ],
            [
                'porte' => ValorRequerimento::PORTE_ENUM['grande'],
                'potencial_poluidor' => ValorRequerimento::POTENCIAL_POLUIDOR_ENUM['medio'],
                'tipo_de_licenca' => ValorRequerimento::TIPO_LICENCA_ENUM['previa'],
                'valor' => 790.00,
            ],
            [
                'porte' => ValorRequerimento::PORTE_ENUM['grande'],
                'potencial_poluidor' => ValorRequerimento::POTENCIAL_POLUIDOR_ENUM['alto'],
                'tipo_de_licenca' => ValorRequerimento::TIPO_LICENCA_ENUM['previa'],
                'valor' => 1050.00,
            ],
            [
                'porte' => ValorRequerimento::PORTE_ENUM['grande'],
                'potencial_poluidor' => ValorRequerimento::POTENCIAL_POLUIDOR_ENUM['baixo'],
                'tipo_de_licenca' => ValorRequerimento::TIPO_LICENCA_ENUM['instalacao'],
                'valor' => 1180.00,
            ],
            [
                'porte' => ValorRequerimento::PORTE_ENUM['grande'],
                'potencial_poluidor' => ValorRequerimento::POTENCIAL_POLUIDOR_ENUM['medio'],
                'tipo_de_licenca' => ValorRequerimento::TIPO_LICENCA_ENUM['instalacao'],
                'valor' => 1580.00,
            ],
            [
                'porte' => ValorRequerimento::PORTE_ENUM['grande'],
                'potencial_poluidor' => ValorRequerimento::POTENCIAL_POLUIDOR_ENUM['alto'],
                'tipo_de_licenca' => ValorRequerimento::TIPO_LICENCA_ENUM['instalacao'],
                'valor' => 2100.00,
            ],
            [
                'porte' => ValorRequerimento::PORTE_ENUM['grande'],
                'potencial_poluidor' => ValorRequerimento::POTENCIAL_POLUIDOR_ENUM['baixo'],
                'tipo_de_licenca' => ValorRequerimento::TIPO_LICENCA_ENUM['operacao'],
                'valor' => 880.00,
            ],
            [
                'porte' => ValorRequerimento::PORTE_ENUM['grande'],
                'potencial_poluidor' => ValorRequerimento::POTENCIAL_POLUIDOR_ENUM['medio'],
                'tipo_de_licenca' => ValorRequerimento::TIPO_LICENCA_ENUM['operacao'],
                'valor' => 1180.00,
            ],
            [
                'porte' => ValorRequerimento::PORTE_ENUM['grande'],
                'potencial_poluidor' => ValorRequerimento::POTENCIAL_POLUIDOR_ENUM['alto'],
                'tipo_de_licenca' => ValorRequerimento::TIPO_LICENCA_ENUM['operacao'],
                'valor' => 1580.00,
            ],
            [
                'porte' => ValorRequerimento::PORTE_ENUM['especial'],
                'potencial_poluidor' => ValorRequerimento::POTENCIAL_POLUIDOR_ENUM['baixo'],
                'tipo_de_licenca' => ValorRequerimento::TIPO_LICENCA_ENUM['simplificada'],
                'valor' => 100.00,
            ],
            [
                'porte' => ValorRequerimento::PORTE_ENUM['especial'],
                'potencial_poluidor' => ValorRequerimento::POTENCIAL_POLUIDOR_ENUM['medio'],
                'tipo_de_licenca' => ValorRequerimento::TIPO_LICENCA_ENUM['simplificada'],
                'valor' => 100.00,
            ],
            [
                'porte' => ValorRequerimento::PORTE_ENUM['especial'],
                'potencial_poluidor' => ValorRequerimento::POTENCIAL_POLUIDOR_ENUM['alto'],
                'tipo_de_licenca' => ValorRequerimento::TIPO_LICENCA_ENUM['simplificada'],
                'valor' => 100.00,
            ],
            [
                'porte' => ValorRequerimento::PORTE_ENUM['especial'],
                'potencial_poluidor' => ValorRequerimento::POTENCIAL_POLUIDOR_ENUM['baixo'],
                'tipo_de_licenca' => ValorRequerimento::TIPO_LICENCA_ENUM['previa'],
                'valor' => 1400.00,
            ],
            [
                'porte' => ValorRequerimento::PORTE_ENUM['especial'],
                'potencial_poluidor' => ValorRequerimento::POTENCIAL_POLUIDOR_ENUM['medio'],
                'tipo_de_licenca' => ValorRequerimento::TIPO_LICENCA_ENUM['previa'],
                'valor' => 1650.00,
            ],
            [
                'porte' => ValorRequerimento::PORTE_ENUM['especial'],
                'potencial_poluidor' => ValorRequerimento::POTENCIAL_POLUIDOR_ENUM['alto'],
                'tipo_de_licenca' => ValorRequerimento::TIPO_LICENCA_ENUM['previa'],
                'valor' => 2450.00,
            ],
            [
                'porte' => ValorRequerimento::PORTE_ENUM['especial'],
                'potencial_poluidor' => ValorRequerimento::POTENCIAL_POLUIDOR_ENUM['baixo'],
                'tipo_de_licenca' => ValorRequerimento::TIPO_LICENCA_ENUM['instalacao'],
                'valor' => 2800.00,
            ],
            [
                'porte' => ValorRequerimento::PORTE_ENUM['especial'],
                'potencial_poluidor' => ValorRequerimento::POTENCIAL_POLUIDOR_ENUM['medio'],
                'tipo_de_licenca' => ValorRequerimento::TIPO_LICENCA_ENUM['instalacao'],
                'valor' => 3300.00,
            ],
            [
                'porte' => ValorRequerimento::PORTE_ENUM['especial'],
                'potencial_poluidor' => ValorRequerimento::POTENCIAL_POLUIDOR_ENUM['alto'],
                'tipo_de_licenca' => ValorRequerimento::TIPO_LICENCA_ENUM['instalacao'],
                'valor' => 4900.00,
            ],
            [
                'porte' => ValorRequerimento::PORTE_ENUM['especial'],
                'potencial_poluidor' => ValorRequerimento::POTENCIAL_POLUIDOR_ENUM['baixo'],
                'tipo_de_licenca' => ValorRequerimento::TIPO_LICENCA_ENUM['operacao'],
                'valor' => 2100.00,
            ],
            [
                'porte' => ValorRequerimento::PORTE_ENUM['especial'],
                'potencial_poluidor' => ValorRequerimento::POTENCIAL_POLUIDOR_ENUM['medio'],
                'tipo_de_licenca' => ValorRequerimento::TIPO_LICENCA_ENUM['operacao'],
                'valor' => 2800.00,
            ],
            [
                'porte' => ValorRequerimento::PORTE_ENUM['especial'],
                'potencial_poluidor' => ValorRequerimento::POTENCIAL_POLUIDOR_ENUM['alto'],
                'tipo_de_licenca' => ValorRequerimento::TIPO_LICENCA_ENUM['operacao'],
                'valor' => 3300.00,
            ],
        ];

        ValorRequerimento::insert($valores);
    }
}
