<?php

namespace Gamez\Illuminate\Support;

use Illuminate\Support\LazyCollection;

/**
 * @template TKey of array-key
 * @template TValue
 *
 * @extends LazyCollection<TKey, TValue>
 */
class LazyTypedCollection extends LazyCollection
{
    use ChecksForValidTypes;

    /**
     * Create a new lazy collection instance.
     *
     * @param  \Illuminate\Contracts\Support\Arrayable<TKey, TValue>|iterable<TKey, TValue>|(Closure(): \Generator<TKey, TValue, mixed, void>)|self<TKey, TValue>|array<TKey, TValue>|null  $source
     *
     * @return void
     */
    public function __construct($source = null)
    {
        parent::__construct($source);

        $this->each(function ($item) {
            $this->assertValidType($item);
        });
    }

    public function map(callable $callback)
    {
        return $this->untype()->map($callback);
    }

    public function pluck($value, $key = null)
    {
        return $this->untype()->pluck($value, $key);
    }

    /**
     * @return array<TKey, mixed>
     */
    public function toArray(): array
    {
        // If the items in the collection are arrayable themselves,
        // toArray() will convert them to arrays as well. If arrays
        // are not allowed in the typed collection, this would
        // fail if we don't untype the collection first
        return $this->untype()->toArray();
    }

    /**
     * Returns an untyped collection with all items
     *
     * @return LazyCollection<TKey, TValue>
     */
    public function untype(): LazyCollection
    {
        return LazyCollection::make($this);
    }
}
