<?php

use App\Models\Film;
use App\Models\Mozi;
use App\Models\User;

function validFilmData(array $overrides = []): array
{
    return array_merge([
        'cim' => 'Uj teszt film',
        'szines' => '1',
        'szinkron' => 'mb',
        'szarmazas' => 'magyar',
        'mufaj' => 'dráma',
        'hossz' => 95,
    ], $overrides);
}

function makeFilm(array $overrides = []): Film
{
    return Film::create(array_merge([
        'cim' => 'Regi film',
        'szines' => true,
        'szinkron' => null,
        'szarmazas' => 'amerikai',
        'mufaj' => 'vígjáték',
        'hossz' => 100,
    ], $overrides));
}

beforeEach(function () {
    $this->admin = User::factory()->create(['role' => 1]);
});

test('guest is redirected to login from every film route', function () {
    $film = makeFilm();

    $this->get('/filmek')->assertRedirect(route('login'));
    $this->get('/filmek/create')->assertRedirect(route('login'));
    $this->post('/filmek', validFilmData())->assertRedirect(route('login'));
    $this->get("/filmek/{$film->id}/edit")->assertRedirect(route('login'));
    $this->put("/filmek/{$film->id}", validFilmData())->assertRedirect(route('login'));
    $this->delete("/filmek/{$film->id}")->assertRedirect(route('login'));
});

test('registered user gets 403 on every film route', function () {
    $film = makeFilm();
    $user = User::factory()->create();

    $this->actingAs($user)->get('/filmek')->assertForbidden();
    $this->actingAs($user)->get('/filmek/create')->assertForbidden();
    $this->actingAs($user)->post('/filmek', validFilmData())->assertForbidden();
    $this->actingAs($user)->get("/filmek/{$film->id}/edit")->assertForbidden();
    $this->actingAs($user)->put("/filmek/{$film->id}", validFilmData())->assertForbidden();
    $this->actingAs($user)->delete("/filmek/{$film->id}")->assertForbidden();

    $this->assertDatabaseCount('films', 1);
});

test('admin sees the film list', function () {
    makeFilm(['cim' => 'Latszik a listaban']);

    $this->actingAs($this->admin)
        ->get('/filmek')
        ->assertOk()
        ->assertSee('Filmek kezelése')
        ->assertSee('Latszik a listaban');
});

test('film list is paginated', function () {
    foreach (range(1, 20) as $i) {
        makeFilm(['cim' => sprintf('Film %02d', $i)]);
    }

    $this->actingAs($this->admin)->get('/filmek')
        ->assertSee('Film 15')
        ->assertDontSee('Film 16');

    $this->actingAs($this->admin)->get('/filmek?page=2')->assertSee('Film 16');
});

test('film list can be searched by title', function () {
    makeFilm(['cim' => 'Alfa kaland']);
    makeFilm(['cim' => 'Beta mese']);

    $this->actingAs($this->admin)->get('/filmek?q=alfa')
        ->assertSee('Alfa kaland')
        ->assertDontSee('Beta mese');
});

test('admin can open the create form', function () {
    $this->actingAs($this->admin)
        ->get('/filmek/create')
        ->assertOk()
        ->assertSee('name="cim"', false)
        ->assertSee('name="hossz"', false);
});

test('admin can create a film', function () {
    $this->actingAs($this->admin)
        ->post('/filmek', validFilmData())
        ->assertRedirect(route('films.index'))
        ->assertSessionHas('status');

    $this->assertDatabaseHas('films', [
        'cim' => 'Uj teszt film',
        'szines' => 1,
        'szinkron' => 'mb',
        'szarmazas' => 'magyar',
        'hossz' => 95,
    ]);
});

test('empty optional fields are stored as null and unchecked colour as false', function () {
    $this->actingAs($this->admin)
        ->post('/filmek', validFilmData(['szines' => '0', 'szinkron' => '', 'mufaj' => '']));

    $film = Film::where('cim', 'Uj teszt film')->first();

    expect($film->szinkron)->toBeNull()
        ->and($film->mufaj)->toBeNull()
        ->and($film->szines)->toBeFalse();
});

test('create validates the input', function () {
    $this->actingAs($this->admin)
        ->post('/filmek', [])
        ->assertSessionHasErrors(['cim', 'szarmazas', 'hossz']);

    $this->actingAs($this->admin)
        ->post('/filmek', validFilmData(['hossz' => 'sok', 'szinkron' => 'xyz']))
        ->assertSessionHasErrors(['hossz', 'szinkron']);

    $this->actingAs($this->admin)
        ->post('/filmek', validFilmData(['hossz' => 601]))
        ->assertSessionHasErrors('hossz');

    $this->assertDatabaseCount('films', 0);
});

test('validation errors are shown in hungarian and the input is kept', function () {
    $this->actingAs($this->admin)
        ->from('/filmek/create')
        ->followingRedirects()
        ->post('/filmek', validFilmData(['hossz' => '', 'cim' => 'Megmarado cim']))
        ->assertSee('A hossz megadása kötelező.')
        ->assertSee('value="Megmarado cim"', false);
});

test('admin can open the edit form with the current values', function () {
    $film = makeFilm(['cim' => 'Szerkesztendo']);

    $this->actingAs($this->admin)
        ->get("/filmek/{$film->id}/edit")
        ->assertOk()
        ->assertSee('value="Szerkesztendo"', false);
});

test('admin can update a film', function () {
    $film = makeFilm();

    $this->actingAs($this->admin)
        ->put("/filmek/{$film->id}", validFilmData(['cim' => 'Modositott cim', 'hossz' => 120]))
        ->assertRedirect(route('films.index'));

    $this->assertDatabaseHas('films', ['id' => $film->id, 'cim' => 'Modositott cim', 'hossz' => 120]);
    $this->assertDatabaseMissing('films', ['cim' => 'Regi film']);
});

test('update validates the input', function () {
    $film = makeFilm();

    $this->actingAs($this->admin)
        ->put("/filmek/{$film->id}", validFilmData(['cim' => '']))
        ->assertSessionHasErrors('cim');

    $this->assertDatabaseHas('films', ['id' => $film->id, 'cim' => 'Regi film']);
});

test('admin can delete a film together with its screenings', function () {
    $film = makeFilm();
    $mozi = Mozi::create(['nev' => 'Teszt mozi', 'iranyitoszam' => '1111', 'cim' => 'Teszt utca 1']);
    $film->mozik()->attach($mozi);

    $this->actingAs($this->admin)
        ->delete("/filmek/{$film->id}")
        ->assertRedirect(route('films.index'))
        ->assertSessionHas('status');

    $this->assertDatabaseMissing('films', ['id' => $film->id]);
    $this->assertDatabaseCount('film_mozi', 0);
    $this->assertDatabaseHas('mozik', ['id' => $mozi->id]);
});

test('deleting a missing film gives 404', function () {
    $this->actingAs($this->admin)->delete('/filmek/9999')->assertNotFound();
});
