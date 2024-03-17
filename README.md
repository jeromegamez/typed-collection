# Type-safe PHP collections based on [Laravel Collections] 

[![Latest Stable Version](https://poser.pugx.org/gamez/typed-collection/v/stable)](https://packagist.org/packages/gamez/typed-collection)
[![Total Downloads](https://poser.pugx.org/gamez/typed-collection/downloads)](https://packagist.org/packages/gamez/typed-collection)
[![Tests](https://github.com/jeromegamez/typed-collection/actions/workflows/tests.yml/badge.svg)](https://github.com/jeromegamez/typed-collection/actions/workflows/tests.yml)
[![Sponsor](https://img.shields.io/static/v1?logo=GitHub&label=Sponsor&message=%E2%9D%A4&color=ff69b4)](https://github.com/sponsors/jeromegamez)

> [!NOTE]  
> Laravel 11 added the `ensure()` collection method that verifies that all elements of
> a collection are of a given type or list of types. However, this verification does not
> prevent items of different types to be added at a later time.

## Installation

The package can be installed with [Composer]:

```bash
$ composer require gamez/typed-collection
```

## Usage

```php
class Person
{
    public $name;

    public function __construct($name)
    {
        $this->name = $name;
    }
}

$taylor = new Person('Taylor');
$jeffrey = new Person('Jeffrey');
```

### Typed Collections

```php
use Gamez\Illuminate\Support\TypedCollection;

class People extends TypedCollection
{
    protected static $allowedTypes = [Person::class];
}

$people = People::make([$taylor, $jeffrey])
    ->each(function (Person $person) {
        printf("This is %s.\n", $person->name);
    });
/* Output:
This is Taylor.
This is Jeffrey.
*/

try {
    People::make('Not a person');
} catch (InvalidArgumentException $e) {
    echo $e->getMessage().PHP_EOL;
}
/* Output:
Output: A People collection only accepts items of the following type(s): Person.
*/
```

### Lazy Typed Collections

```php
use Gamez\Illuminate\Support\LazyTypedCollection;

class LazyPeople extends LazyTypedCollection
{
    protected static $allowedTypes = [Person::class];
}

$lazyPeople = LazyPeople::make([$taylor, $jeffrey])
    ->each(function (Person $person) {
        printf("This is %s.\n", $person->name);
    });
/* Output:
This is Lazy Taylor.
This is Lazy Jeffrey.
*/

try {
    LazyPeople::make('Nope!');
} catch (InvalidArgumentException $e) {
    echo $e->getMessage().PHP_EOL;
}
/* Output:
Output: A People collection only accepts objects of the following type(s): Person.
*/
```

### Supported types

Supported types are class strings, like `Person::class`, or types recognized by the
[`get_debug_type()` function](https://www.php.net/get-debug-type), `int`, `float`,
`string`, `bool`, and `array`.

### Helper functions

The `typedCollect()` helper function enables you to dynamically create typed collections
on the fly:

```php
$dateTimes = typedCollect([new DateTime(), new DateTime()], DateTimeInterface::class);
```

For further information on how to use Laravel Collections,
have a look at the [official documentation].

[Laravel Collections]: https://laravel.com/docs/collections
[official documentation]: https://laravel.com/docs/collections
[Composer]: https://getcomposer.org 
