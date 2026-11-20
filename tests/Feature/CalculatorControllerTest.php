<?php

test('get calc shows default form', function () {
    $this->get('/teszt')
        ->assertOk()
        ->assertSee('Számológép')
        ->assertSee('name="a"', false)
        ->assertSee('name="b"', false)
        ->assertSee('value="add"', false);
});

test('post calc addition', function () {
    $this->post('/teszt', ['a' => 12, 'b' => 8, 'op' => 'add'])
        ->assertOk()
        ->assertSee('12 + 8 =')
        ->assertSee('20')
        ->assertSee('data-testid="result"', false);
});

test('post calc division formats decimal result', function () {
    $this->post('/teszt', ['a' => 5, 'b' => 2, 'op' => 'divide'])
        ->assertOk()
        ->assertSee('5 / 2 =')
        ->assertSee('2,50')
        ->assertSee('data-testid="result"', false);
});

test('post calc division by zero shows error', function () {
    $this->post('/teszt', ['a' => 10, 'b' => 0, 'op' => 'divide'])
        ->assertOk()
        ->assertSee('You cannot divide by zero!')
        ->assertSee('data-testid="error"', false);
});

test('missing or invalid data triggers validation errors', function () {
    $this->post('/teszt', [])
        ->assertSessionHasErrors(['a', 'b', 'op']);

    $this->post('/teszt', ['a' => 'nem-szam', 'b' => 5, 'op' => 'add'])
        ->assertSessionHasErrors(['a']);
});

test('unknown operation triggers validation error', function () {
    $this->post('/teszt', ['a' => 5, 'b' => 5, 'op' => 'xyz'])
        ->assertSessionHasErrors(['op']);
});
