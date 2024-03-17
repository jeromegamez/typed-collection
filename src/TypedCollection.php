<?php

namespace Gamez\Illuminate\Support;

use Illuminate\Support\Collection;

/**
 * @template TKey of array-key
 * @template TValue
 *
 * @extends Collection<TKey, TValue>
 */
abstract class TypedCollection extends Collection
{
    use ChecksForValidTypes;

    /**
     * @param \Illuminate\Contracts\Support\Arrayable<TKey, TValue>|iterable<TKey, TValue>|null $items
     */
    public function __construct($items = [])
    {
        $this->assertValidTypes(...$items);

        parent::__construct($items);
    }

    /**
     * Push one or more items onto the end of the collection.
     *
     * @param TValue ...$values
     *
     * @return $this
     */
    public function push(...$values)
    {
        foreach ($values as $value) {
            $this->assertValidType($value);
        }

        return parent::push(...$values);
    }

    /**
     * @param TKey $key
     * @param TValue $value
     */
    public function offsetSet($key, $value): void
    {
        $this->assertValidType($value);

        parent::offsetSet($key, $value);
    }

    /**
     * @param TValue $value
     * @param ?TKey $key
     */
    public function prepend($value, $key = null)
    {
        $this->assertValidType($value);

        return parent::prepend($value, $key);
    }

    /**
     * @param TValue $value
     */
    public function add($value)
    {
        $this->assertValidType($value);

        return parent::add($value);
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
     * @return Collection<int, TKey>
     */
    public function keys()
    {
        return $this->untype()->keys();
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
     * @return Collection<TKey, TValue>
     */
    public function untype(): Collection
    {
        return new Collection($this->items);
    }
}
