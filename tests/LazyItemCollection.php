<?php

namespace Gamez\Illuminate\Support\Tests;

use Gamez\Illuminate\Support\LazyTypedCollection;
use Gamez\Illuminate\Support\TypedCollection;

/**
 * @extends LazyTypedCollection<array-key, Item>
 */
class LazyItemCollection extends LazyTypedCollection
{
    protected static array $allowedTypes = [Item::class];
}
