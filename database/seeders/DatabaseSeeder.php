<?php

namespace Database\Seeders;

use App\Models\Requerente;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {

        $this->call([
            DocumentoSeeder::class,
            SetorSeeder::class,
            CnaeSeeder::class,
            EnderecoSeeder::class,
            TelefoneSeeder::class,
            TipoAnalistaSeeder::class,
            UserSeeder::class,
            RequerenteSeeder::class,
            EmpresaSeeder::class,
            ValoresSeeder::class,
            EspecieMudaSeeder::class,
            NovoAnalistaSeeder::class,
            RequerimentoSeeder::class,
            BoletoCobrancasSeeder::class,
        ]);
    }
}
