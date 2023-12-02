<?php

namespace Results\Option;

use Results\Result\Ok;
use Throwable;

/**
 * @template T
 *
 * @implements Option<mixed>
 */
class Some implements Option
{
    /**
     * @param  T  $value
     */
    public function __construct(private mixed $value)
    {
    }

    public function expect(string $msg): mixed
    {
        return $this->value;
    }

    public function unwrap(): mixed
    {
        return $this->value;
    }

    public function unwrapOr(mixed $fallback): mixed
    {
        return $this->value;
    }

    /**
     * @template T2
     *
     * @param  callable(T): Option<T2>  $fn
     * @return Option<T2>
     */
    public function andThen(callable $fn): Option
    {
        return $fn($this->value);
    }

    /**
     * @template U
     *
     * @param  callable(T): U  $fn
     * @return Option<U>
     */
    public function map(callable $fn): Option
    {
        return new Some($fn($this->value));
    }

    /**
     * @return Ok<T>
     */
    public function toResult(Throwable $e): Ok
    {
        return new Ok($this->value);
    }
}
