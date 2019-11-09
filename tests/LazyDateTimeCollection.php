<?php

namespace Gamez\Illuminate\Support\Tests;

use DateTimeInterface;
use Gamez\Illuminate\Support\TypedCollection;
use Gamez\Illuminate\Support\LazyTypedCollection;

class LazyDateTimeCollection extends LazyTypedCollection
{
    protected static $allowedTypes = [DateTimeInterface::class];
}
