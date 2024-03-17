<?php

namespace Gamez\Illuminate\Support;

use InvalidArgumentException;

trait ChecksForValidTypes
{
    /** @var list<class-string|non-empty-string> */
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
        $itemType = get_debug_type($item);

        foreach (static::$allowedTypes as $allowedType) {
            if (($itemType === $allowedType) || ($item instanceof $allowedType)) {
                return;
            }
        }

        throw new InvalidArgumentException(sprintf(
            'A %s collection only accepts items of the following type(s): %s.',
            get_class($this), implode(', ', static::$allowedTypes)
        ));
    }
}
