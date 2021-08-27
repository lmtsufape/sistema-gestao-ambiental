<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'Secretário(a)',
            'email' => 'secretaria@secretaria.com',
            'role' => User::ROLE_ENUM['secretario'],
            'password' => Hash::make('12345678'),
            'email_verified_at' => now(),
        ]);
    }
}
