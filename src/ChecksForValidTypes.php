<?php

namespace Gamez\Illuminate\Support;

use InvalidArgumentException;

trait ChecksForValidTypes
{
    /** @var array<int, class-string>  */
    protected static $allowedTypes = [];

    /**
     * @param mixed ...$items
     * @throws InvalidArgumentException
     */
    protected function assertValidTypes(...$items): void
    {
        foreach ($items as $item) {
            $this->assertValidType($item);
        }
    }

    /**
     * @param mixed $item
     * @throws InvalidArgumentException
     */
    protected function assertValidType($item): void
    {
        foreach (static::$allowedTypes as $allowedType) {
            if ($item instanceof $allowedType) {
                return;
            }
        }

        throw new InvalidArgumentException(sprintf(
            'A %s collection only accepts objects of the following type(s): %s.',
            get_class($this), implode(', ', static::$allowedTypes)
        ));
    }
}
