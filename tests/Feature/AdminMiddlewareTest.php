<?php

use App\Models\User;
use Illuminate\Support\Facades\Route;

beforeEach(function () {
    Route::middleware(['web', 'auth', 'admin'])->get('/admin-teszt', fn () => 'admin-ok');
});

test('guest is redirected to login from an admin route', function () {
    $this->get('/admin-teszt')->assertRedirect(route('login'));
});

test('registered user gets 403 on an admin route', function () {
    $this->actingAs(User::factory()->create())->get('/admin-teszt')->assertForbidden();
});

test('admin can open an admin route', function () {
    $admin = User::factory()->create(['role' => 1]);

    $this->actingAs($admin)->get('/admin-teszt')->assertOk()->assertSee('admin-ok');
});

test('seeded roles are recognised', function () {
    expect(User::factory()->create(['role' => 1])->isAdmin())->toBeTrue()
        ->and(User::factory()->create()->isAdmin())->toBeFalse();
});
