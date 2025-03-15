<?php

namespace Gamez\Illuminate\Support;

use Illuminate\Support\Enumerable;
use Illuminate\Support\LazyCollection;

/**
 * @template TKey of array-key
 * @template TValue
 *
 * @extends LazyCollection<TKey, TValue>
 */
abstract class LazyTypedCollection extends LazyCollection
{
    /**
     * @use ChecksForValidTypes<TKey, TValue>
     */
    use ChecksForValidTypes;

    public function __construct($source = null)
    {
        parent::__construct($source);

        foreach ($this->source as $item) {
            $this->assertValidType($item);
        }
    }

    /**
     * @template TMapValue
     *
     * @param  callable(TValue, TKey): TMapValue  $callback
     * @return LazyCollection<TKey, TMapValue>
     */
    public function map(callable $callback): LazyCollection
    {
        return $this->untype()->map($callback);
    }

    /**
     * @param string|array<array-key, string>  $value
     * @param string|null $key
     * @return LazyCollection<array-key, mixed>
     */
    public function pluck($value, $key = null): LazyCollection
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
        return new LazyCollection($this);
    }
}
