<?php

namespace Gamez\Illuminate\Support\Tests;

use Gamez\Illuminate\Support\TypedCollection;
use Illuminate\Support\Collection;
use InvalidArgumentException;
use PHPUnit\Framework\Attributes\DoesNotPerformAssertions;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

class TypedCollectionTest extends TestCase
{
    private ItemCollection $collection;

    protected function setUp(): void
    {
        $this->collection = new ItemCollection();
    }

    #[Test]
    public function it_cannot_be_created_with_an_unsupported_type_of_item(): void
    {
        $this->expectException(InvalidArgumentException::class);
        new ItemCollection([new Item(), 'string', new Item()]);
    }

    #[Test]
    #[DoesNotPerformAssertions]
    public function it_can_be_created_with_supported_types(): void
    {
        new ItemCollection([new Item()]);
    }

    #[Test]
    #[DoesNotPerformAssertions]
    public function a_supported_value_can_be_added(): void
    {
        $this->collection->add(new Item());
    }

    #[Test]
    public function an_unsupported_value_can_not_be_added(): void
    {
        $this->expectException(InvalidArgumentException::class);
        /** @phpstan-ignore argument.type */
        $this->collection->add('string');
    }

    #[Test]
    #[DoesNotPerformAssertions]
    public function a_supported_value_can_be_prepended(): void
    {
        $this->collection->prepend(new Item());
    }

    #[Test]
    public function an_unsupported_value_can_not_be_prepended(): void
    {
        $this->expectException(InvalidArgumentException::class);
        /** @phpstan-ignore argument.type */
        $this->collection->prepend('string');
    }

    #[Test]
    #[DoesNotPerformAssertions]
    public function a_supported_value_can_be_pushed(): void
    {
        $this->collection->push(new Item());
    }

    #[Test]
    public function an_unsupported_value_can_not_be_pushed(): void
    {
        $this->expectException(InvalidArgumentException::class);
        /** @phpstan-ignore argument.type */
        $this->collection->push('string');
    }

    #[Test]
    #[DoesNotPerformAssertions]
    public function a_supported_value_can_be_put(): void
    {
        $this->collection->put('key', new Item());
    }

    #[Test]
    public function an_unsupported_value_can_not_be_put(): void
    {
        $this->expectException(InvalidArgumentException::class);
        /** @phpstan-ignore argument.type */
        $this->collection->put('key', 'string');
    }

    #[Test]
    public function it_can_be_untyped(): void
    {
        $untyped = $this->collection->untype();

        $this->assertInstanceOf(Collection::class, $untyped);
        $this->assertNotInstanceOf(ItemCollection::class, $untyped);
        $this->assertNotInstanceOf(TypedCollection::class, $untyped);
    }

    #[Test]
    public function it_can_be_converted_to_an_array(): void
    {
        $this->collection->push(new Item());
        $this->collection->push(new Item());

        $this->assertCount(2, $this->collection->toArray());
    }

    /**
     * @see https://github.com/jeromegamez/typed-collection/issues/2
     */
    #[Test]
    public function it_works_with_items_that_themselves_are_arrayable(): void
    {
        $collection = new ItemCollection();
        $collection->push(new Item());
        $this->assertCount(1, $collection->toArray());
    }

    /**
     * @see https://github.com/jeromegamez/typed-collection/issues/7
     */
    #[Test]
    public function it_accepts_items_to_be_pushed(): void
    {
        $collection = new ItemCollection();

        $collection->push(...[new Item(1, 'value'), new Item(2, 'value')]);
        $this->assertCount(2, $collection);

        $collection->push(new Item(3, 'value'), new Item(4, 'value'));
        $this->assertCount(4, $collection);
    }

    /**
     * @see https://github.com/jeromegamez/typed-collection/issues/4
     */
    #[Test]
    public function items_can_be_plucked(): void
    {
        $collection = new ItemCollection([
            /**  */
            new Item(1, 'a'),
            new Item(2, 'b'),
            new Item(3, 'c'),
        ]);

        $this->assertEquals([null, null, null], $collection->pluck('name')->toArray());
        $this->assertEquals([1, 2, 3], $collection->pluck('id')->toArray());
    }

    #[Test]
    public function it_returns_keys(): void
    {
        $collection = new ItemCollection();
        $collection->put('a' ,new Item());
        $collection->put('b', new Item());

        $this->assertEquals(['a', 'b'], $collection->keys()->toArray());
    }

    /**
     * @see https://github.com/jeromegamez/typed-collection/issues/11
     */
    #[Test]
    public function items_are_untyped_when_mapped(): void
    {
        $source = new ItemCollection([new Item(2, 'two')]);

        $mapped = $source->map(static fn(Item $item) => $item->value);

        $this->assertSame(['two'], $mapped->toArray());
    }

    #[Test]
    public function items_can_be_of_simple_type(): void
    {
        $collection = new class extends TypedCollection {
            protected static array $allowedTypes = ['int', 'bool', 'string'];
        };

        $collection->add(1);
        $collection->add(true);
        $collection->add('string');

        $this->expectException(InvalidArgumentException::class);
        $collection->add(new Item());
    }
}
