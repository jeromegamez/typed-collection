<?php

use Gamez\Illuminate\Support\TypedCollection;

if (!function_exists('typedCollect')) {
    /**
     * Create an anonymous typed collection
     *
     * @template TKey of array-key
     * @template TValue
     *
     * @param \Illuminate\Contracts\Support\Arrayable<TKey, TValue>|iterable<TKey, TValue>|null $value
     * @param string|string[] $types
     * @return \Illuminate\Support\Collection<TKey, TValue>
     */
    function typedCollect($value = [], string|array $types = [])
    {
        $types = is_array($types) ? $types : [$types];

        $collection = new class extends TypedCollection {};

        $reflectionClass = new ReflectionClass($collection);
        $reflectionProperty = $reflectionClass->getProperty('allowedTypes');
        $reflectionProperty->setValue($collection, $types);

        return new $collection($value);
    }
}
