<?php

use Bosunski\Results\Option\None;
use Bosunski\Results\Result\Err;

test('expect returns throws error value', function (): void {
    $e = new Exception('some message');
    $err = new Err($e);
    expect(fn () => $err->expect('some message'))->toThrow(Exception::class, 'some message');
});

test('else returns value', function (): void {
    $e = new Exception('some message');
    $err = new Err($e);
    expect($err->else(2))->toBe(2);
});

test('unwrapOr returns value', function (): void {
    $e = new Exception('some message');
    $err = new Err($e);
    expect($err->unwrapOr(2))->toBe(2);
});

test('expectErr returns error value', function (): void {
    $e = new Exception('some message');
    $err = new Err($e);
    expect($err->expectErr('some message'))->toBe($e);
});

test('map returns same object', function (): void {
    $e = new Exception('some message');
    $err = new Err($e);
    $newErr = $err->map(fn (int $x): int => $x + 1);

    expect($newErr)->toBe($err);
});

test('unwrap throws error', function (): void {
    $e = new Exception('some message');
    $err = new Err($e);
    expect(fn () => $err->unwrap())->toThrow(Exception::class, 'some message');
});

test('andThen returns same object', function (): void {
    $e = new Exception('some message');
    $err = new Err($e);
    $newErr = $err->andThen(fn (int $x): Err => new Err($e));

    expect($newErr)->toBe($err);
});

test('toOption returns None', function (): void {
    $e = new Exception('some message');
    $err = new Err($e);
    $newNone = $err->toOption(2);

    expect($newNone)->toBeInstanceOf(None::class);
});

test('mapErr returns new Err', function (): void {
    $e = new Exception('some message');
    $err = new Err($e);
    $newErr = $err->mapErr(fn (Exception $e): Exception => new Exception('new message'));

    expect($newErr)->not()->toBe($err)
        ->and($newErr->expectErr('some message'))->toBeInstanceOf(Exception::class)
        ->and($newErr->expectErr('some message')->getMessage())->toBe('new message');
});

test('isErr returns true', function (): void {
    $e = new Exception('some message');
    $err = new Err($e);
    expect($err->isErr())->toBeTrue();
});

test('isOk returns false', function (): void {
    $e = new Exception('some message');
    $err = new Err($e);
    expect($err->isOk())->toBeFalse();
});
