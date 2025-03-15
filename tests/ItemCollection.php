<?php

namespace Gamez\Illuminate\Support\Tests;

use Gamez\Illuminate\Support\TypedCollection;
use Illuminate\Support\Collection;

/**
 * @extends TypedCollection<array-key, Item>
 */
class ItemCollection extends TypedCollection
{
    protected static array $allowedTypes = [Item::class];
}
