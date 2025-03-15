<?php

use Gamez\Illuminate\Support\TypedCollection;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Support\Collection;

if (!function_exists('typedCollect')) {
    /**
     * Create an anonymous typed collection
     *
     * @template TKey of array-key
     * @template TValue
     *
     * @param Arrayable<TKey, TValue>|iterable<TKey, TValue>|null $value
     * @param string|string[] $types
     * @return Collection<TKey, TValue>
     */
    function typedCollect($value = [], string|array $types = []): Collection
    {
        $types = is_array($types) ? $types : [$types];

        $collection = new class extends TypedCollection {};

        $reflectionClass = new ReflectionClass($collection);
        $reflectionProperty = $reflectionClass->getProperty('allowedTypes');
        $reflectionProperty->setValue($collection, $types);

        return new $collection($value);
    }
}
