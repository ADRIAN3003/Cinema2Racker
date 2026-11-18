<?php

use App\Models\Message;
use App\Models\User;

function validContactData(array $overrides = []): array
{
    return array_merge([
        'name' => 'Teszt Elek',
        'email' => 'elek@example.com',
        'subject' => 'Kerdes a musorrol',
        'message' => 'Mikor jatsszak ezt a filmet a belvarosi mozikban?',
    ], $overrides);
}

test('contact page is visible for guests with the form', function () {
    $this->get('/kapcsolat')
        ->assertOk()
        ->assertSee('Kapcsolat')
        ->assertSee('name="name"', false)
        ->assertSee('name="email"', false)
        ->assertSee('name="subject"', false)
        ->assertSee('name="message"', false);
});

test('contact menu item appears for guests', function () {
    $this->get('/')->assertSee('Kapcsolat');
});

test('guest can send a message and it is saved', function () {
    $this->post('/kapcsolat', validContactData())
        ->assertRedirect(route('contact'))
        ->assertSessionHas('status');

    $this->assertDatabaseCount('messages', 1);
    $this->assertDatabaseHas('messages', [
        'name' => 'Teszt Elek',
        'email' => 'elek@example.com',
        'subject' => 'Kerdes a musorrol',
    ]);
});

test('success message is shown after sending', function () {
    $this->followingRedirects()
        ->post('/kapcsolat', validContactData())
        ->assertOk()
        ->assertSee('Köszönjük, az üzeneted megérkezett.');
});

test('logged in user can send a message too', function () {
    $this->actingAs(User::factory()->create())
        ->post('/kapcsolat', validContactData())
        ->assertRedirect(route('contact'));

    $this->assertDatabaseCount('messages', 1);
});

test('form is prefilled for logged in users', function () {
    $user = User::factory()->create(['name' => 'Kiss Pista', 'email' => 'pista@example.com']);

    $this->actingAs($user)
        ->get('/kapcsolat')
        ->assertSee('value="Kiss Pista"', false)
        ->assertSee('value="pista@example.com"', false);
});

test('every field is required', function () {
    $this->post('/kapcsolat', [])
        ->assertSessionHasErrors(['name', 'email', 'subject', 'message']);

    $this->assertDatabaseCount('messages', 0);
});

test('email must be valid', function () {
    $this->post('/kapcsolat', validContactData(['email' => 'nem-email']))
        ->assertSessionHasErrors('email');

    $this->assertDatabaseCount('messages', 0);
});

test('message must be at least ten characters long', function () {
    $this->post('/kapcsolat', validContactData(['message' => 'rovid']))
        ->assertSessionHasErrors('message');
});

test('too long values are rejected', function () {
    $this->post('/kapcsolat', validContactData([
        'name' => str_repeat('a', 101),
        'subject' => str_repeat('b', 151),
        'message' => str_repeat('c', 2001),
    ]))->assertSessionHasErrors(['name', 'subject', 'message']);
});

test('validation errors are shown in hungarian and the input is kept', function () {
    $this->from('/kapcsolat')
        ->followingRedirects()
        ->post('/kapcsolat', validContactData(['email' => 'nem-email', 'subject' => '']))
        ->assertSee('Adj meg egy érvényes e-mail címet.')
        ->assertSee('A tárgy megadása kötelező.')
        ->assertSee('value="Teszt Elek"', false);
});

test('messages are stored with a timestamp', function () {
    $this->post('/kapcsolat', validContactData());

    expect(Message::first()->created_at)->not->toBeNull();
});
