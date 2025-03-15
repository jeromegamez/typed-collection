<?php

namespace Gamez\Illuminate\Support\Tests;

use Illuminate\Contracts\Support\Arrayable;

/**
 * @implements Arrayable<int, string>
 */
final class Item implements Arrayable
{
    public function __construct(
        public int $id = 1,
        public string $value = 'value',
    ) {}

    public function toArray()
    {
        /** @phpstan-ignore return.type */
        return [$this->id, $this->value];
    }
}
