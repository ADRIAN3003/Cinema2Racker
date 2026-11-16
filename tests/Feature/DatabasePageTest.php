<?php

use App\Models\Film;
use App\Models\Mozi;
use Database\Seeders\FilmMoziSeeder;
use Database\Seeders\FilmSeeder;
use Database\Seeders\MoziSeeder;

beforeEach(function () {
    $this->seed([FilmSeeder::class, MoziSeeder::class, FilmMoziSeeder::class]);
});

test('seeders load the whole cinema dataset', function () {
    expect(Film::count())->toBe(154)
        ->and(Mozi::count())->toBe(42)
        ->and(DB::table('film_mozi')->count())->toBe(355);
});

test('film and mozi are connected by a many to many relation', function () {
    $film = Film::has('mozik')->first();

    expect($film->mozik)->not->toBeEmpty()
        ->and($film->mozik->first()->films->pluck('id'))->toContain($film->id);
});

test('database page is visible for guests and lists the data', function () {
    $this->get('/adatbazis')
        ->assertOk()
        ->assertSee('Ágnes öcsénk')
        ->assertSee('Petőfi híd budai hídfő');
});

test('the database menu item appears in the menu', function () {
    $this->get('/')->assertSee('Adatbázis');
});
