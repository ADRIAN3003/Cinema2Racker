<?php

use App\Models\Film;
use Database\Seeders\FilmMoziSeeder;
use Database\Seeders\FilmSeeder;
use Database\Seeders\MoziSeeder;

beforeEach(function () {
    $this->seed([FilmSeeder::class, MoziSeeder::class, FilmMoziSeeder::class]);
});

test('vendeg is eleri a diagram oldalt', function () {
    $this->get('/diagram')
        ->assertOk()
        ->assertSee('Diagram');
});

test('a nezet megkapja az adatokat es a mufaj osszeg egyezik a filmek szamaval', function () {
    $response = $this->get('/diagram');

    $response->assertViewHas('mufajLabels')
        ->assertViewHas('mufajValues')
        ->assertViewHas('topMozikLabels')
        ->assertViewHas('topMozikValues')
        ->assertViewHas('szinesLabels')
        ->assertViewHas('szinesValues')
        ->assertViewHas('szarmazasLabels')
        ->assertViewHas('szarmazasValues')
        ->assertViewHas('filmCount', 154)
        ->assertViewHas('moziCount', 42);

    $mufajValues = $response->viewData('mufajValues');
    expect(array_sum($mufajValues))->toBe(154);
});

test('az oldal forrasaban szerepel mind a 4 canvas azonositoja', function () {
    $this->get('/diagram')
        ->assertOk()
        ->assertSee('id="chartMufaj"', false)
        ->assertSee('id="chartMozik"', false)
        ->assertSee('id="chartSzines"', false)
        ->assertSee('id="chartSzarmazas"', false);
});

test('az ures mufaju filmek az ismeretlen csoportba kerulnek', function () {
    Film::create([
        'cim' => 'Teszt Film Null Mufaj',
        'szines' => true,
        'szinkron' => null,
        'szarmazas' => 'magyar',
        'mufaj' => null,
        'hossz' => 90,
    ]);

    $response = $this->get('/diagram');
    $labels = $response->viewData('mufajLabels');
    $values = $response->viewData('mufajValues');

    expect($labels)->toContain('ismeretlen');

    $idx = array_search('ismeretlen', $labels);
    expect($idx)->not->toBeFalse();
    expect($values[$idx])->toBeGreaterThan(0);
});
