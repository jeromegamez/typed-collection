<?php

namespace Gamez\Illuminate\Support;

use Illuminate\Support\Collection;

class TypedCollection extends Collection
{
    use ChecksForValidTypes;

    public function __construct($items = [])
    {
        parent::__construct($items);

        $this->assertValidTypes();
    }

    public function push($value)
    {
        $this->assertValidType($value);

        return parent::push($value);
    }

    public function offsetSet($key, $value)
    {
        $this->assertValidType($value);

        parent::offsetSet($key, $value);
    }

    public function prepend($value, $key = null)
    {
        $this->assertValidType($value);

        return parent::prepend($value, $key);
    }

    public function add($value)
    {
        $this->assertValidType($value);

        // Using push, because add has only been added after 5.4
        return $this->push($value);
    }

    /**
     * Returns an untyped collection with all items
     */
    public function untype()
    {
        return Collection::make($this->items);
    }
}
