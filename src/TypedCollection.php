<?php

namespace Gamez\Illuminate\Support;

use Illuminate\Support\Collection;

class TypedCollection extends Collection
{
    use ChecksForValidTypes;

    public function __construct($items = [])
    {
        $this->assertValidTypes(...$items);

        parent::__construct($items);
    }

    /**
     * Push one or more items onto the end of the collection.
     *
     * @param  mixed  $values [optional]
     * @return $this
     */
    public function push(...$values)
    {
        foreach ($values as $value) {
            $this->assertValidType($value);
        }

        return parent::push(...$values);
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

        return parent::add($value);
    }

    public function pluck($value, $key = null)
    {
        return $this->untype()->pluck($value, $key);
    }

    public function keys()
    {
        return $this->untype()->keys();
    }

    /**
     * @return array
     */
    public function toArray()
    {
        // If the items in the collection are arrayable themselves,
        // toArray() will convert them to arrays as well. If arrays
        // are not allowed in the typed collection, this would
        // fail if we don't untype the collection first
        return $this->untype()->toArray();
    }

    /**
     * Returns an untyped collection with all items
     */
    public function untype(): Collection
    {
        return Collection::make($this->items);
    }
}
