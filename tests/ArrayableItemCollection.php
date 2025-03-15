<?php

namespace Gamez\Illuminate\Support\Tests;

use Gamez\Illuminate\Support\TypedCollection;

class ArrayableItemCollection extends TypedCollection
{
    protected static array $allowedTypes = [ArrayableItem::class];
}
