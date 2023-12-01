<?php

namespace Results\Option;

use Exception;
use Results\Result\Err;
use Throwable;

/**
 * @implements Option<never-return>
 */
class None implements Option
{
    /**
     * @return never-return
     *
     * @throws Exception
     */
    public function expect(string $msg): mixed
    {
        throw new Exception($msg);
    }

    /**
     * @throws Exception
     */
    public function unwrap(): mixed
    {
        throw new Exception('called `Option::unwrap()` on a `None` value');
    }

    public function unwrapOr(mixed $default): mixed
    {
        return $default;
    }

    public function andThen(callable $fn): Option
    {
        return $this;
    }

    public function map(callable $fn): None
    {
        return $this;
    }

    /**
     * @template E of Throwable
     *
     * @param  E  $e
     * @return Err<E>
     */
    public function toResult(Throwable $e): Err
    {
        return new Err($e);
    }
}
