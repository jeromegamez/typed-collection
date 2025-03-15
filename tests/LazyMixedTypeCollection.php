<?php

declare(strict_types=1);

namespace Gamez\Illuminate\Support\Tests;

use Gamez\Illuminate\Support\LazyTypedCollection;

/**
 * @extends LazyTypedCollection<array-key, int|string|Item>
 */
final class LazyMixedTypeCollection extends LazyTypedCollection
{
    protected static array $allowedTypes = ['int', 'string', Item::class];
}
