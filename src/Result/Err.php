<?php

namespace Bosunski\Results\Result;

use Bosunski\Results\Option\None;
use Bosunski\Results\Option\Option;
use Throwable;

/**
 * @template E of Throwable
 *
 * @implements Result<never-return, E>
 */
class Err implements Result
{
    /**
     * @param  E  $err
     */
    public function __construct(private Throwable $err)
    {
    }

    /**
     * @return never-return
     *
     * @throws Throwable
     */
    public function expect(string $msg): mixed
    {
        throw $this->err;
    }

    /**
     * @template T2
     *
     * @param  T2  $value
     * @return T2
     */
    public function else(mixed $value): mixed
    {
        return $value;
    }

    /**
     * @template T2
     *
     * @param  T2  $default
     * @return T2
     */
    public function unwrapOr(mixed $default): mixed
    {
        return $default;
    }

    /**
     * @return E
     */
    public function expectErr(string $msg): mixed
    {
        return $this->err;
    }

    /**
     * @return never
     *
     * @throws Throwable
     */
    public function unwrap(): mixed
    {
        throw $this->err;
    }

    /**
     * @return $this
     */
    public function map(callable $fn): Err
    {
        return $this;
    }

    /**
     * @return $this
     */
    public function andThen(callable $fn): Err
    {
        return $this;
    }

    /**
     * @return Option<never>
     */
    public function toOption(mixed $u): Option
    {
        return new None();
    }

    /**
     * @template E2 of Throwable
     *
     * @param  callable(E): E2  $fn
     * @return Err<E2>
     */
    public function mapErr(callable $fn): Result
    {
        return new Err($fn($this->err));
    }

    public function isOk(): bool
    {
        return false;
    }

    public function isErr(): bool
    {
        return true;
    }
}
