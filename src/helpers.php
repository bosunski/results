<?php

namespace Results;

use Results\Option\None;
use Results\Option\Option;
use Results\Option\Some;
use Results\Result\Err;
use Results\Result\Ok;
use Results\Result\Result;
use Throwable;

if (! function_exists('Some')) {
    /**
     * @template T
     *
     * @param  T  $value
     * @return Some<T>
     */
    function Some(mixed $value): Some
    {
        return new Some($value);
    }
}

if (! function_exists('None')) {
    function None(): None
    {
        return new None();
    }
}

if (! function_exists('Option')) {
    /**
     * @template T
     *
     * @param  T | null  $value
     * @return Option<T>
     */
    function Option(mixed $value): Option
    {
        return $value === null ? None() : Some($value);
    }
}

if (! function_exists('Ok')) {
    /**
     * @template T
     *
     * @param  T  $value
     * @return Ok<T>
     */
    function Ok(mixed $value): Ok
    {
        return new Ok($value);
    }
}

if (! function_exists('Err')) {
    /**
     * @template E of Throwable
     *
     * @param  E  $e
     * @return Err<E>
     */
    function Err(Throwable $e): Err
    {
        return new Err($e);
    }
}

if (! function_exists('Result')) {
    /**
     * @return ($value is Throwable ? Err<Throwable> : Ok<mixed>)
     */
    function Result(mixed $value): Ok|Err
    {
        return $value instanceof Throwable ? Err($value) : Ok($value);
    }
}

if (! function_exists('wrap')) {
    /**
     * @template T
     *
     * @param  callable(): T  $fn
     * @return Result<T, Throwable>
     */
    function wrap(callable $fn): Result
    {
        try {
            return Ok($fn());
        } catch (Throwable $e) {
            return Err($e);
        }
    }
}
