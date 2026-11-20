<?php

use App\Services\Calculator;

test('osszeadas', function () {
    $calculator = new Calculator();

    expect($calculator->add(15, 5))->toBe(20);
});

test('kivonas pozitiv es negativ eredmennyel', function () {
    $calculator = new Calculator();

    expect($calculator->subtract(15, 5))->toBe(10)
        ->and($calculator->subtract(5, 15))->toBe(-10);
});

test('szorzas pozitiv es negativ szamokkal', function () {
    $calculator = new Calculator();

    expect($calculator->multiply(4, 5))->toBe(20)
        ->and($calculator->multiply(4, -5))->toBe(-20)
        ->and($calculator->multiply(-4, -5))->toBe(20);
});

test('szorzas nullaval', function () {
    $calculator = new Calculator();

    expect($calculator->multiply(10, 0))->toBe(0)
        ->and($calculator->multiply(0, 10))->toBe(0);
});

test('osztas', function () {
    $calculator = new Calculator();

    expect($calculator->divide(5, 2))->toBe(2.5);
});

test('nullaval osztas kivetelt dob', function () {
    $calculator = new Calculator();

    expect(fn () => $calculator->divide(10, 0))
        ->toThrow(InvalidArgumentException::class, 'You cannot divide by zero!');
});
