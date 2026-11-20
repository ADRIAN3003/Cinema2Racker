<?php

use App\Models\Message;
use App\Models\User;

test('vendeg atiranyitodik a bejelentkezesi oldalra', function () {
    $this->get('/uzenetek')->assertRedirect(route('login'));
});

test('bejelentkezett felhasznalo latja az uzenetek oldalt', function () {
    $user = User::factory()->create();
    Message::factory()->create(['subject' => 'Teszt targy']);

    $this->actingAs($user)
        ->get('/uzenetek')
        ->assertOk()
        ->assertSee('Teszt targy');
});

test('az uzenetek sorrendje legujabb elol', function () {
    $user = User::factory()->create();
    Message::factory()->create(['subject' => 'Regi', 'created_at' => now()->subDays(2)]);
    Message::factory()->create(['subject' => 'Ujabb', 'created_at' => now()->subDay()]);
    Message::factory()->create(['subject' => 'Legujabb', 'created_at' => now()]);

    $this->actingAs($user)
        ->get('/uzenetek')
        ->assertOk()
        ->assertSeeInOrder(['Legujabb', 'Ujabb', 'Regi']);
});

test('ures allapotban latszik a meg nem erkezett uzenet felirat', function () {
    $user = User::factory()->create();

    $this->actingAs($user)
        ->get('/uzenetek')
        ->assertOk()
        ->assertSee('Még nem érkezett üzenet.');
});

test('11 uzenetnel a lapozo megjelenik', function () {
    $user = User::factory()->create();
    $uniqueSubject = 'EzCsakA2Oldalon';
    Message::factory()->create(['subject' => $uniqueSubject, 'created_at' => now()->subDays(20)]);
    for ($i = 0; $i < 10; $i++) {
        Message::factory()->create(['created_at' => now()->subDays($i)]);
    }

    $this->actingAs($user)
        ->get('/uzenetek')
        ->assertOk()
        ->assertDontSee($uniqueSubject);

    $this->actingAs($user)
        ->get('/uzenetek?page=2')
        ->assertOk()
        ->assertSee($uniqueSubject);
});
