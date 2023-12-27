<?php

use Bosunski\Results\Option\None;
use Bosunski\Results\Option\Some;
use Bosunski\Results\Result\Err;
use Bosunski\Results\Result\Ok;

use function Bosunski\Results\Err;
use function Bosunski\Results\None;
use function Bosunski\Results\Ok;
use function Bosunski\Results\Option;
use function Bosunski\Results\Result;
use function Bosunski\Results\Some;
use function Bosunski\Results\wrap;

test('Ok returns an Ok', function (): void {
    $ok = Ok(1);
    expect($ok)->toBeInstanceOf(Ok::class)
        ->and($ok->unwrap())->toBe(1);
});

test('Some returns a Some', function (): void {
    $some = Some(1);
    expect($some)->toBeInstanceOf(Some::class)
        ->and($some->unwrap())->toBe(1);
});

test('Option returns a Some if value is not null', function (): void {
    $some = Option(1);
    expect($some)->toBeInstanceOf(Some::class)
        ->and($some->unwrap())->toBe(1);
});

test('Option returns a None if value is null', function (): void {
    $none = Option(null);
    expect($none)->toBeInstanceOf(None::class);
});

test('None() returns a None', function (): void {
    $none = None();
    expect($none)->toBeInstanceOf(None::class);
});

test('Err() returns an Err', function (): void {
    $err = Err(new Exception('some message'));
    expect($err)->toBeInstanceOf(Err::class);
});

test('Result() returns an Ok if value is not null', function (): void {
    $ok = Result(1);
    expect($ok)->toBeInstanceOf(Ok::class);
});

test('Result() returns an Err if value is null', function (): void {
    $err = Result($exception = new Exception('some message'));
    expect($err)->toBeInstanceOf(Err::class)
        ->and($e = $err->expectErr(''))->toBeInstanceOf(Exception::class)
        ->and($e)->toBe($exception)
        ->and($e->getMessage())->toBe('some message');
});

test('wrapResult() returns Ok if successful', function (): void {
    $ok = wrap(fn () => 1);
    expect($ok)->toBeInstanceOf(Ok::class)
        ->and($ok->unwrap())->toBe(1);
});

test('wrapResult() returns Err if unsuccessful', function (): void {
    $exception = new Exception('some message');
    $err = wrap(fn () => throw $exception);
    expect($err)->toBeInstanceOf(Err::class)
        ->and($e = $err->expectErr(''))->toBeInstanceOf(Exception::class)
        ->and($e)->toBe($exception)
        ->and($e->getMessage())->toBe('some message');
});
