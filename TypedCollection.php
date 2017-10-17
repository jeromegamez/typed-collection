<?php

namespace Gamez\Illuminate\Support;

use Illuminate\Support\Collection;

class TypedCollection extends Collection
{
    protected static $allowedTypes = [];

    public function __construct($items = [])
    {
        $this->assertValidTypes($this->getArrayableItems($items));

        parent::__construct($items);
    }

    public function prepend($value, $key = null)
    {
        $this->assertValidType($value);

        return parent::prepend($value, $key);
    }

    public function push($value)
    {
        $this->assertValidType($value);

        return parent::push($value);
    }

    public function put($key, $value)
    {
        $this->assertValidType($value);

        return parent::put($key, $value);
    }

    public function map(callable $callback)
    {
        try {
            return parent::map($callback);
        } catch (\InvalidArgumentException $e) {
            return Collection::make($this->items)->map($callback);
        }
    }

    /**
     * Returns an untyped collection with all items
     */
    public function untype()
    {
        return Collection::make($this->items);
    }

    protected function assertValidType($item)
    {
        $result = array_reduce(static::$allowedTypes, function ($isValid, $allowedType) use ($item) {
            return $isValid ?: $item instanceof $allowedType;
        }, false);

        if (!$result) {
            throw new \InvalidArgumentException(sprintf(
                'A %s collection only accepts objects of the following type(s): %s.',
                get_class($this), implode(', ', static::$allowedTypes)
            ));
        }
    }

    protected function assertValidTypes(array $items)
    {
        array_map(function ($item) {
            $this->assertValidType($item);
        }, $items);
    }
}
