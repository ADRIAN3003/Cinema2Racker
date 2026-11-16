<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FilmMoziSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('film_mozi')->insert(TsvReader::read('film_mozi'));
    }
}
