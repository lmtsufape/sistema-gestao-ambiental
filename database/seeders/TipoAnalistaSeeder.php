<?php

namespace Database\Seeders;

use App\Models\TipoAnalista;
use Illuminate\Database\Seeder;

class TipoAnalistaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $tipos = [
            [
                'tipo'  => 1,
            ],
            [
                'tipo'  => 2,
            ],
        ];

        TipoAnalista::insert($tipos);
    }
}
