<?php

use App\Models\Mozi;
use App\Models\User;

beforeEach(function () {
    $this->withoutVite();
});

test('vendeg getJson react mozik 401-et ad', function () {
    $this->getJson('/react/mozik')->assertUnauthorized();
});

test('nem admin felhasznalo 403-at kap a json vegpontra', function () {
    $user = User::factory()->create();

    $this->actingAs($user)
        ->getJson('/react/mozik')
        ->assertForbidden();
});

test('admin eleri a mozik listajat', function () {
    $admin = User::factory()->create(['role' => 1]);
    Mozi::create([
        'nev' => 'Teszt Mozi A',
        'iranyitoszam' => '1111',
        'cim' => 'Teszt utca 1.',
        'telefon' => '0612345678',
    ]);

    $this->actingAs($admin)
        ->getJson('/react/mozik')
        ->assertOk()
        ->assertJsonFragment(['nev' => 'Teszt Mozi A']);
});

test('admin letrehozhat uj mozit', function () {
    $admin = User::factory()->create(['role' => 1]);

    $data = [
        'nev' => 'Uj Mozi',
        'iranyitoszam' => '1234',
        'cim' => 'Uj utca 2.',
        'telefon' => '06201234567',
    ];

    $this->actingAs($admin)
        ->postJson('/react/mozik', $data)
        ->assertCreated()
        ->assertJsonFragment(['nev' => 'Uj Mozi']);

    $this->assertDatabaseHas('mozik', [
        'nev' => 'Uj Mozi',
        'iranyitoszam' => '1234',
    ]);
});

test('admin modolithat mozit', function () {
    $admin = User::factory()->create(['role' => 1]);
    $mozi = Mozi::create([
        'nev' => 'Eredeti Mozi',
        'iranyitoszam' => '1111',
        'cim' => 'Eredeti cim',
        'telefon' => null,
    ]);

    $this->actingAs($admin)
        ->putJson('/react/mozik/'.$mozi->id, [
            'nev' => 'Modositott Mozi',
            'iranyitoszam' => '2222',
            'cim' => 'Modositott cim',
            'telefon' => '06301112233',
        ])
        ->assertOk()
        ->assertJsonFragment(['nev' => 'Modositott Mozi']);

    $this->assertDatabaseHas('mozik', [
        'id' => $mozi->id,
        'nev' => 'Modositott Mozi',
        'iranyitoszam' => '2222',
    ]);
});

test('admin torolhet mozit', function () {
    $admin = User::factory()->create(['role' => 1]);
    $mozi = Mozi::create([
        'nev' => 'Torlendo Mozi',
        'iranyitoszam' => '3333',
        'cim' => 'Torlendo cim',
    ]);

    $this->actingAs($admin)
        ->deleteJson('/react/mozik/'.$mozi->id)
        ->assertNoContent();

    $this->assertDatabaseMissing('mozik', [
        'id' => $mozi->id,
    ]);
});

test('validacios hibak eseten 422-t ad errors kulccsal', function () {
    $admin = User::factory()->create(['role' => 1]);

    $this->actingAs($admin)
        ->postJson('/react/mozik', [
            'nev' => '',
            'iranyitoszam' => '12',
            'cim' => '',
        ])
        ->assertStatus(422)
        ->assertJsonStructure(['errors' => ['nev', 'iranyitoszam', 'cim']]);
});

test('get react oldal elerhetosege', function () {
    $admin = User::factory()->create(['role' => 1]);

    $this->get('/react')->assertRedirect(route('login'));

    $this->actingAs($admin)
        ->get('/react')
        ->assertOk()
        ->assertSee('id="react-root"', false);
});

test('nem admin felhasznalo 403-at kap a react oldalra', function () {
    $user = User::factory()->create();

    $this->actingAs($user)
        ->get('/react')
        ->assertForbidden();
});
