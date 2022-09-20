<?php

namespace Database\Seeders;

use App\Models\TipoAnalista;
use Illuminate\Database\Seeder;

class NovoAnalistaSeeder extends Seeder
{
    /**
     * Run a new analista type databaseTipoAnalistaSeeder seeds.
     *
     * @return void
     */
    public function run()
    {
        TipoAnalista::create([
            'tipo' => "4",
        ]);
    }
}
