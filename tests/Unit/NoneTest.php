<?php

use Results\Option\None;

test('unwrap returns value', function () {
    $some = new None();
    expect(fn () => $some->unwrap())->toThrow(Exception::class);
});

test('expect returns value', function () {
    $none = new None();
    expect(fn () => $none->expect('some message'))->toThrow(Exception::class, 'some message');
});

test('unWrapOr returns value not the fallback', function () {
    $none = new None();
    expect($none->unwrapOr(2))->toBe(2);
});

test('andThen returns option with value', function () {
    $oldNone = new None();
    $newNone = $oldNone->andThen(fn (int $x): None => new None());
    expect($newNone)->toBe($oldNone);
});

test('map returns same object', function () {
    $oldNone = new None();
    $newNone = $oldNone->map(fn (int $x): int => $x + 1);
    expect($newNone)->toBe($oldNone);
});
