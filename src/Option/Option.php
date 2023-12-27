<?php

namespace Bosunski\Results\Option;

use Bosunski\Results\Result\Result;
use Throwable;

/**
 * @template T
 */
interface Option
{
    /**
     * @return T
     */
    public function expect(string $msg): mixed;

    /**
     * @return T
     */
    public function unwrap(): mixed;

    /**
     * @template T2
     *
     * @param  T2  $fallback
     * @return T | T2
     */
    public function unwrapOr(mixed $fallback): mixed;

    /**
     * @template T2
     *
     * @param  callable(T): Option<T2>  $fn
     * @return Option<T2>
     */
    public function andThen(callable $fn): Option;

    /**
     * @template U
     *
     * @param  callable(T): U  $fn
     * @return Option<U>
     */
    public function map(callable $fn): Option;

    /**
     * @template E of Throwable
     *
     * @param  E  $e
     * @return Result<T, E>
     */
    public function toResult(Throwable $e): Result;

    /**
     * @phpstan-assert-if-true !true $this->isNone()
     */
    public function isSome(): bool;

    /**
     * @phpstan-assert-if-true !true $this->isSome()
     */
    public function isNone(): bool;
}
