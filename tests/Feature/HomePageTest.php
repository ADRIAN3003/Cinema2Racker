<?php

use App\Models\Film;
use App\Models\Mozi;
use App\Models\User;

function homeFilm(string $cim, ?string $mufaj = 'dráma'): Film
{
    return Film::create([
        'cim' => $cim,
        'szines' => true,
        'szinkron' => null,
        'szarmazas' => 'magyar',
        'mufaj' => $mufaj,
        'hossz' => 90,
    ]);
}

function homeMozi(string $nev): Mozi
{
    return Mozi::create(['nev' => $nev, 'iranyitoszam' => '1111', 'cim' => 'Teszt utca 1']);
}

test('home page is visible for guests', function () {
    $this->get('/')
        ->assertOk()
        ->assertSee('Főoldal')
        ->assertSee('Műsor böngészése')
        ->assertSee('Regisztráció');
});

test('home page works with an empty database', function () {
    $this->get('/')
        ->assertOk()
        ->assertSee('Még nincs film az adatbázisban.')
        ->assertSee('Még nincs mozi az adatbázisban.');
});

test('home page shows the database statistics', function () {
    $film = homeFilm('Elso film', 'dráma');
    homeFilm('Masodik film', 'vígjáték');
    homeFilm('Harmadik film', null);
    $mozi = homeMozi('Kozponti mozi');
    $film->mozik()->attach($mozi);

    $this->get('/')
        ->assertViewHas('stats', [
            'films' => 3,
            'mozik' => 1,
            'vetitesek' => 1,
            'mufajok' => 2,
        ]);
});

test('home page lists the most played films and the busiest cinemas', function () {
    $nepszeru = homeFilm('Nepszeru film');
    $ritka = homeFilm('Ritka film');
    $a = homeMozi('Alfa mozi');
    $b = homeMozi('Beta mozi');
    $nepszeru->mozik()->attach([$a->id, $b->id]);
    $ritka->mozik()->attach($a);

    $response = $this->get('/')
        ->assertSee('Nepszeru film')
        ->assertSee('Alfa mozi');

    expect($response->viewData('topFilms')->first()->cim)->toBe('Nepszeru film')
        ->and($response->viewData('topMozik')->first()->nev)->toBe('Alfa mozi');
});

test('home page shows at most five items in each list', function () {
    foreach (range(1, 7) as $i) {
        homeFilm('Film '.$i);
        homeMozi('Mozi '.$i);
    }

    $response = $this->get('/');

    expect($response->viewData('topFilms'))->toHaveCount(5)
        ->and($response->viewData('topMozik'))->toHaveCount(5);
});

test('logged in user sees the messages card instead of the login card', function () {
    $this->get('/')->assertSee('Lépj be, hogy lásd a beérkezett üzeneteket.');

    $this->actingAs(User::factory()->create())
        ->get('/')
        ->assertSee('A beérkezett üzenetek, a legújabbak elöl.')
        ->assertDontSee('Lépj be, hogy lásd a beérkezett üzeneteket.')
        ->assertDontSee('Regisztráció');
});

test('footer shows the authors with their neptun codes', function () {
    $this->get('/')
        ->assertSee('Medve Adrián')
        ->assertSee('N0M2FB')
        ->assertSee('Czibulya Márk')
        ->assertSee('P7VEQO');
});

test('the page is responsive and uses the dark bootstrap theme', function () {
    $this->get('/')
        ->assertSee('name="viewport" content="width=device-width, initial-scale=1"', false)
        ->assertSee('data-bs-theme="dark"', false)
        ->assertSee('bootstrap@5.3.3', false);
});
