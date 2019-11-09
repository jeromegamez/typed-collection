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

    /**
     * Returns an untyped collection with all items
     */
    public function untype()
    {
        return LazyCollection::make($this);
    }
}
