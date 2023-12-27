# Results

Results is a PHP library that provides a set of helper functions and classes for handling optional values and results of operations. It is inspired by the [`Option`](https://doc.rust-lang.org/std/option/enum.Option.html) and [`Result`](https://doc.rust-lang.org/std/result/enum.Result.html) types in Rust.

## Installation

You can install the library via Composer:

```bash
composer require bosunski/results
```

## Usage

### Option

The `Option` type represents an optional value: every `Option` is either `Some` and contains a value, or `None`, and does not.

```php
use function Bosunski\Results\Option;

$some = Option('value'); // Some
$none = Option(null); // None
```

### Result

The `Result` type is a type that represents either success (`Ok`) or failure (`Err`).

```php
use function Bosunski\Results\Result;

$ok = Result('value'); // Ok
$err = Result(new Exception('error')); // Err
```

### Helper Functions

The library provides a set of helper functions for creating `Option` and `Result` instances:

- `Some(mixed $value): Some`
- `None(): None`
- `Option(mixed $value): Option`
- `Ok(mixed $value): Ok`
- `Err(Throwable $e): Err`
- `Result(mixed $value): Ok|Err`
- `wrap(callable $fn): Result`

### Examples

Optional values and results in PHP can be represented using the `Option` and `Result` types provided by the Results library. Here are some examples:

```php
use function Bosunski\Results\Option;
use function Bosunski\Results\Result;

// Options
$some = Option('value'); // Some
$none = Option(null); // None

// Results
$ok = Result('value'); // Ok
$err = Result(new Exception('error')); // Err
```

In the above examples:

- `Option('value')` creates an `Option` that contains a value (referred to as `Some`).
- `Option(null)` creates an `Option` that does not contain a value (referred to as `None`).
- `Result('value')` creates a `Result` that represents a successful operation (`Ok`).
- `Result(new Exception('error'))` creates a `Result` that represents a failed operation (`Err`).


Let's dive into more complex examples of using the `Option` and `Result` types in PHP.

Consider a scenario where we have a function that may or may not return a value. We can use the `Option` type to handle this uncertainty.

```php
use Bosunski\Results\Option as OptionInterface;
use function Bosunski\Results\Option;

function findUserById($id): OptionInterface {
    // Assume getUserFromDatabase is a function that returns a User object if found, null otherwise
    $user = getUserFromDatabase($id);
    
    return Option($user);
}

$userOption = findUserById(123);

// We can then handle the optional value using the methods provided by the Option type
if ($userOption->isSome()) {
    $user = $userOption->unwrap();
    // Do something with the user
} else {
    // Handle the case where no user was found
}
```

Now, let's consider a scenario where we have a function that can either succeed or fail. We can use the `Result` type to handle this.

```php
use Bosunski\Results\Result\Result as ResultInterface;
use function Bosunski\Results\Result;

function divide(int $numerator, int $denominator): ResultInterface {
    if ($denominator == 0) {
        return Err(new Exception("Cannot divide by zero"));
    } else {
        return Ok($numerator / $denominator);
    }
}

$result = divide(10, 0);

// We can then handle the result using the methods provided by the Result type
if ($result->isOk()) {
    $value = $result->unwrap();
    // Do something with the value
} else {
    $error = $result->unwrapErr();
    // Handle the error
}
```

In these examples, the `Option` and `Result` types provide a way to handle optional values and the results of operations in a safe and expressive manner.

### The wrap Function

The `wrap` function is a utility function provided by the library. It is designed to handle operations that can throw an error. The `wrap` function executes a `callable` and returns its result wrapped in a `Result` object. If the callable function throws an exception, the wrap function catches it and returns an `Err` object containing the exception.

> [!IMPORTANT]
> The error that `wrap` captures depends on your error configuration. Also, `wrap` will only capture instances of `Throwable`. If your function throws something that is not an instance of `Throwable`, it will not be captured by `wrap`.

Here's an example of how you might use the wrap function:

```php
use function Bosunski\Results\wrap;

function mightThrowException(): int {
    if (rand(0, 1) === 1) {
        throw new Exception('An error occurred');
    }

    return 42;
}

$result = wrap('mightThrowException');

if ($result->isOk()) {
    echo "Success: " . $result->unwrap();
} else {
    echo "Error: " . $result->unwrapErr()->getMessage();
}
```

In this example, `mightThrowException` is a function that might throw an exception. We pass this function to `wrap`, which executes it, catch *any* error and wraps the result in a `Result` object. We then check if the result is an instance of `Ok` or `Err` and handle it accordingly.

The `wrap` function provides a safe and expressive way to handle operations that can throw errors, allowing you to focus on your application logic rather than error handling when you don't need to.


## Testing

You can run `composer run test` to run the unit tests for this library.

## License

This project is licensed under the MIT License.