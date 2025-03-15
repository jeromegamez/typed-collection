<?php

namespace Gamez\Illuminate\Support\Tests;

use Gamez\Illuminate\Support\LazyTypedCollection;

class LazyArrayableItemCollection extends LazyTypedCollection
{
    protected static array $allowedTypes = [ArrayableItem::class];
}
