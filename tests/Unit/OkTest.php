<?php

use Bosunski\Results\Option\Some;
use Bosunski\Results\Result\Ok;

test('expect returns value', function () {
    $ok = new Ok(1);
    expect($ok->expect('some message'))->toBe(1);
});

test('else returns value', function () {
    $ok = new Ok(1);
    expect($ok->else(2))->toBe(1);
});

test('unwrapOr returns value', function () {
    $ok = new Ok(1);
    expect($ok->unwrapOr(2))->toBe(1);
});

test('expectErr throws error', function () {
    $ok = new Ok(1);
    expect(fn () => $ok->expectErr('some message'))->toThrow(Exception::class, 'some message');
});

test('map returns new Ok', function () {
    $ok = new Ok(1);
    $newOk = $ok->map(fn (int $x): int => $x + 1);

    expect($newOk)->not()->toBe($ok)
        ->and($newOk->unwrap())->toBe(2);
});

test('unwrap returns value', function () {
    $ok = new Ok(1);
    expect($ok->unwrap())->toBe(1);
});

test('andThen returns new Ok', function () {
    $ok = new Ok(1);
    $newOk = $ok->andThen(fn (int $x): Ok => new Ok($x + 1));

    expect($newOk)->not()->toBe($ok)
        ->and($newOk->unwrap())->toBe(2);
});

test('toOption returns Some', function () {
    $ok = new Ok(1);
    $newSome = $ok->toOption(2);

    expect($newSome)->toBeInstanceOf(Some::class)
        ->and($newSome->unwrap())->toBe(1);
});

test('mapErr returns same object', function () {
    $ok = new Ok(1);
    $newOk = $ok->mapErr(fn (Throwable $x): Throwable => new Exception('some message'));

    expect($newOk)->toBe($ok);
});

test('isOk returns true', function () {
    $ok = new Ok(1);
    expect($ok->isOk())->toBeTrue();
});

test('isErr returns false', function () {
    $ok = new Ok(1);
    expect($ok->isErr())->toBeFalse();
});
