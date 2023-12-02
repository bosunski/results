<?php

use Results\Option\None;
use Results\Option\Some;
use Results\Result\Err;
use Results\Result\Ok;

use function Results\Err;
use function Results\None;
use function Results\Ok;
use function Results\Option;
use function Results\Result;
use function Results\Some;
use function Results\wrapResult;

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
    $ok = wrapResult(fn () => 1);
    expect($ok)->toBeInstanceOf(Ok::class)
        ->and($ok->unwrap())->toBe(1);
});

test('wrapResult() returns Err if unsuccessful', function (): void {
    $exception = new Exception('some message');
    $err = wrapResult(fn () => throw $exception);
    expect($err)->toBeInstanceOf(Err::class)
        ->and($e = $err->expectErr(''))->toBeInstanceOf(Exception::class)
        ->and($e)->toBe($exception)
        ->and($e->getMessage())->toBe('some message');
});
