<?php

use Results\Option\Some;

test('unwrap returns value', function () {
    $some = new Some(1);
    expect($some->unwrap())->toBe(1);
});

test('expect returns value', function () {
    $some = new Some(1);
    expect($some->expect('some message'))->toBe(1);
});

test('unWrapOr returns value not the fallback', function () {
    $some = new Some(1);
    expect($some->unwrapOr(2))->toBe(1);
});

test('andThen returns option with value', function () {
    $some = new Some(1);
    $newSome = $some->andThen(function (int $x): Some {
        return new Some($x + 1);
    });

    expect($newSome)->not()->toBe($some)
        ->and($newSome->unwrap())->toBe(2);
});

test('map returns option with value', function () {
    $some = new Some(1);
    $newSome = $some->map(fn (int $x): int => $x + 1);

    expect($newSome)->not()->toBe($some)
        ->and($newSome->unwrap())->toBe(2);
});
