<?php

use App\Models\User;
use Illuminate\Support\Facades\Route;

beforeEach(function () {
    foreach (['contact', 'chart', 'calc.form', 'messages', 'films.index', 'react'] as $name) {
        Route::middleware('web')->get('/menu-teszt/'.$name, fn () => 'x')->name($name);
    }
    Route::getRoutes()->refreshNameLookups();
});

test('guest sees only the public menu items', function () {
    $this->get('/')
        ->assertSee('Adatbázis')
        ->assertSee('Kapcsolat')
        ->assertSee('Diagram')
        ->assertSee('Teszt')
        ->assertSee('Bejelentkezés')
        ->assertSee('Regisztráció')
        ->assertDontSee('Üzenetek')
        ->assertDontSee('Filmek kezelése')
        ->assertDontSee('Kijelentkezés');
});

test('registered user sees messages and logout but not admin items', function () {
    $this->actingAs(User::factory()->create())->get('/')
        ->assertSee('Üzenetek')
        ->assertSee('Kijelentkezés')
        ->assertDontSee('Bejelentkezés')
        ->assertDontSee('Filmek kezelése')
        ->assertDontSee('React');
});

test('admin sees the admin menu items', function () {
    $this->actingAs(User::factory()->create(['role' => 1]))->get('/')
        ->assertSee('Üzenetek')
        ->assertSee('Filmek kezelése')
        ->assertSee('React')
        ->assertSee('Kijelentkezés');
});
