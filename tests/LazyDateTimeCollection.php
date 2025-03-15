<?php

namespace Gamez\Illuminate\Support\Tests;

use DateTimeInterface;
use Gamez\Illuminate\Support\LazyTypedCollection;

class LazyDateTimeCollection extends LazyTypedCollection
{
    protected static array $allowedTypes = [DateTimeInterface::class];
}
