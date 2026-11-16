<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FilmSeeder extends Seeder
{
    public function run(): void
    {
        $now = now();
        $rows = array_map(fn ($r) => $r + ['created_at' => $now, 'updated_at' => $now], TsvReader::read('films'));

        DB::table('films')->insert($rows);
    }
}
