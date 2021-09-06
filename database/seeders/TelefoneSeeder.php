<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TelefoneSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('telefones')->insert([
            'numero' => '(82) 99661-7025',
        ]);

        DB::table('telefones')->insert([
            'numero' => '(34) 98192-2518',
        ]);
    }
}
