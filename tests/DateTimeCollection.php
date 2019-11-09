<?php

namespace Gamez\Illuminate\Support\Tests;

use DateTimeInterface;
use Gamez\Illuminate\Support\TypedCollection;

class DateTimeCollection extends TypedCollection
{
    protected static $allowedTypes = [DateTimeInterface::class];
}
