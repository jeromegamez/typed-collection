<?php

declare(strict_types=1);

namespace Gamez\Illuminate\Support\Tests;

use Gamez\Illuminate\Support\LazyTypedCollection;

final class LazyMixedTypeCollection extends LazyTypedCollection
{
    protected static array $allowedTypes = ['int', 'string', ArrayableItem::class];
}
