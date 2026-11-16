<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Teszt felhasználók: egy regisztrált (role=2) és egy admin (role=1).
     */
    public function run(): void
    {
        DB::table('users')->insert([
            'name' => 'User1',
            'email' => 'aaa@aaa.hu',
            'password' => bcrypt('aaaaaaaa'),
            'role' => 2,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('users')->insert([
            'name' => 'admin',
            'email' => 'bbb@bbb.hu',
            'password' => bcrypt('bbbbbbbb'),
            'role' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
