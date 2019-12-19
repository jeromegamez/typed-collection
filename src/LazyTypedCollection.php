<?php

namespace Gamez\Illuminate\Support;

use Illuminate\Support\LazyCollection;

class LazyTypedCollection extends LazyCollection
{
    use ChecksForValidTypes;

    public function __construct($source = null)
    {
        parent::__construct($source);

        $this->assertValidTypes();
    }

    public function pluck($value, $key = null)
    {
        return $this->untype()->pluck($value, $key);
    }

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
    public function untype()
    {
        return LazyCollection::make($this);
    }
}
