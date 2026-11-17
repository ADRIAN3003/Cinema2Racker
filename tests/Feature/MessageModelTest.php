<?php

use App\Models\Message;

test('message factory creates a saved message', function () {
    $message = Message::factory()->create();

    expect($message->exists)->toBeTrue()
        ->and($message->subject)->not->toBeEmpty();

    $this->assertDatabaseHas('messages', ['id' => $message->id, 'email' => $message->email]);
});

test('message can be created with the fillable fields', function () {
    $message = Message::create([
        'name' => 'Teszt Elek',
        'email' => 'elek@example.com',
        'subject' => 'Kerdes',
        'message' => 'Mikor jatsszak a filmet?',
    ]);

    expect($message->created_at)->not->toBeNull();
    $this->assertDatabaseCount('messages', 1);
});
