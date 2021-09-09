<?php

namespace Database\Seeders;

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
        // \App\Models\User::factory(10)->create();

        $this->call([
            DocumentoSeeder::class,
            SetorSeeder::class,
            CnaeSeeder::class,
            EnderecoSeeder::class,
            TelefoneSeeder::class,
            UserSeeder::class,
            RequerenteSeeder::class,
            EmpresaSeeder::class,
            ValoresSeeder::class,
        ]);
    }
}
