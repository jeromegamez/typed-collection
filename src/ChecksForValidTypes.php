<?php

namespace Gamez\Illuminate\Support;

trait ChecksForValidTypes
{
    protected static $allowedTypes = [];

    protected function assertValidTypes(...$items)
    {
        foreach ($items as $item) {
            $this->assertValidType($item);
        }
    }

    protected function assertValidType($item)
    {
        foreach (static::$allowedTypes as $allowedType) {
            if ($item instanceof $allowedType) {
                return;
            }
        }

        throw new \InvalidArgumentException(sprintf(
            'A %s collection only accepts objects of the following type(s): %s.',
            get_class($this), implode(', ', static::$allowedTypes)
        ));
    }
}
