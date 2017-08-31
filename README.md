# Type-safe PHP collections based on [Laravel Collections] 

[![Latest Stable Version](https://poser.pugx.org/gamez/typed-collection/v/stable)](https://packagist.org/packages/gamez/typed-collection)
[![Total Downloads](https://poser.pugx.org/gamez/typed-collection/downloads)](https://packagist.org/packages/gamez/typed-collection)
[![Build Status](https://travis-ci.org/jeromegamez/typed-collection.svg?branch=master)](https://travis-ci.org/jeromegamez/typed-collection)

## Installation

The package can be installed with [Composer]:

```bash
$ composer require gamez/typed-collection
```

## Usage

```php
use Gamez\Illuminate\Support\TypedCollection;

class Person
{
    public $name;

    public function __construct($name)
    {
        $this->name = $name;
    }
}

class People extends TypedCollection
{
    protected static $allowedTypes = [Person::class];
}

People::make([new Person('Taylor'), new Person('Jeffrey')])
    ->each(function (Person $person) {
        printf("This is %s.\n", $person->name);
    });
/* Output:
This is Taylor.
This is Jeffrey.
*/

try {
    People::make('Nope!');
} catch (InvalidArgumentException $e) {
    echo $e->getMessage().PHP_EOL;
    // Output: A People collection only accepts objects of the following types: Person.
}
```

For further information on how to use Laravel Collections,
have a look at the [official documentation].

[Laravel Collections]: https://laravel.com/docs/collections
[official documentation]: https://laravel.com/docs/collections
[Composer]: https://getcomposer.org 
