<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('users')->insert([
            [
                'name'     => 'Admin',
                'email'    => 'admin@polygames.com',
                'role'     => 'admin',
                'password' => Hash::make('password123'),
            ],
            [
                'name'     => 'Staff',
                'email'    => 'staff@polygames.com',
                'role'     => 'staff',
                'password' => Hash::make('password123'),
            ],
        ]);
    }
}
