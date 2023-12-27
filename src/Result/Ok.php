<?php

namespace Bosunski\Results\Result;

use Bosunski\Results\Option\Option;
use Bosunski\Results\Option\Some;
use Exception;
use Throwable;

/**
 * @template T
 *
 * @implements Result<T, Throwable>
 */
class Ok implements Result
{
    public function __construct(private mixed $value)
    {
    }

    public function expect(string $msg): mixed
    {
        return $this->value;
    }

    /**
     * @throws Exception
     */
    public function expectErr(string $msg): mixed
    {
        throw new Exception($msg);
    }

    public function unwrap(): mixed
    {
        return $this->value;
    }

    public function unwrapOr(mixed $default): mixed
    {
        return $this->value;
    }

    public function andThen(callable $fn): Result
    {
        return $fn($this->value);
    }

    public function map(callable $fn): Result
    {
        return new Ok($fn($this->value));
    }

    public function toOption(mixed $u): Option
    {
        return new Some($this->value);
    }

    public function mapErr(callable $fn): Result
    {
        return $this;
    }

    public function else(mixed $value): mixed
    {
        return $this->value;
    }

    public function isOk(): bool
    {
        return true;
    }

    public function isErr(): bool
    {
        return false;
    }
}
