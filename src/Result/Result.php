<?php

namespace Results\Result;

use Results\Option\Option;
use Throwable;

/**
 * @template T of mixed
 * @template E of Throwable
 */
interface Result
{
    /**
     * @return T
     */
    public function expect(string $msg): mixed;

    /**
     * @return E
     */
    public function expectErr(string $msg): mixed;

    /**
     * @return T
     */
    public function unwrap(): mixed;

    /**
     * @template T2
     *
     * @param  T2  $default
     * @return T | T2
     */
    public function unwrapOr(mixed $default): mixed;

    /**
     * @template T2
     * @template E2 of Throwable
     *
     * @param  (callable(T): Ok<T2> | callable(T): Err<E2> | callable(T): Result<T2, E2>)  $fn
     * @return Result<T2, E>
     */
    public function andThen(callable $fn): Result;

    /**
     * @template U of mixed
     *
     * @param  callable(T): U  $fn
     * @return Result<U, E>
     */
    public function map(callable $fn): Result;

    /**
     * @template U of mixed
     *
     * @param  U  $u
     * @return Option<U>
     */
    public function toOption(mixed $u): Option;

    /**
     * @template F of Throwable
     *
     * @param  callable(E): F  $fn
     * @return Result<T, F>
     */
    public function mapErr(callable $fn): Result;

    /**
     * @template T2
     *
     * @param  T2  $value
     * @return T | T2
     */
    public function else(mixed $value): mixed;

    /**
     * @phpstan-assert-if-true !true $this->isErr()
     */
    public function isOk(): bool;

    /**
     * @phpstan-assert-if-true !true $this->isOk()
     */
    public function isErr(): bool;
}
