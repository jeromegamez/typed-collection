<?php

namespace Gamez\Illuminate\Support\Tests;

use DateTime;
use DateTimeImmutable;
use Gamez\Illuminate\Support\LazyTypedCollection;
use InvalidArgumentException;
use PHPUnit\Framework\Attributes\DoesNotPerformAssertions;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Illuminate\Support\LazyCollection;

class LazyTypedCollectionTest extends TestCase
{
    private LazyItemCollection $collection;

    protected function setUp(): void
    {
        $this->collection = new LazyItemCollection();
    }

    #[Test]
    public function it_cannot_be_created_with_an_unsupported_type_of_item(): void
    {
        $this->expectException(InvalidArgumentException::class);
        new LazyItemCollection([new Item(), 'string', new Item()]);
    }

    #[Test]
    #[DoesNotPerformAssertions]
    public function it_can_be_created_with_supported_types(): void
    {
        new LazyItemCollection([new Item(), new Item(), new Item()]);
    }

    #[Test]
    public function it_can_be_untyped(): void
    {
        $untyped = $this->collection->untype();

        $this->assertInstanceOf(LazyCollection::class, $untyped);
        $this->assertNotInstanceOf(LazyItemCollection::class, $untyped);
        $this->assertNotInstanceOf(LazyTypedCollection::class, $untyped);
    }

    #[Test]
    public function it_can_be_converted_to_an_array(): void
    {
        $collection = new LazyItemCollection([new Item(), new Item()]);

        $this->assertCount(2, $collection->toArray());
    }

    /**
     * @see https://github.com/jeromegamez/typed-collection/issues/2
     */
    #[Test]
    public function it_works_with_items_that_themselves_are_arrayable(): void
    {
        $collection = new LazyItemCollection([new Item()]);
        $this->assertCount(1, $collection->toArray());
    }

    /**
     * @see https://github.com/jeromegamez/typed-collection/issues/4
     */
    #[Test]
    public function items_can_be_plucked(): void
    {
        $collection = new LazyItemCollection([
            new Item(1, 'a'),
            new Item(2, 'b'),
            new Item(3, 'c')
        ]);

        $this->assertEquals([null, null, null], $collection->pluck('name')->toArray());
        $this->assertEquals([1, 2, 3], $collection->pluck('id')->toArray());
    }

    /**
     * @see https://github.com/jeromegamez/typed-collection/issues/11
     */
    #[Test]
    public function items_are_untyped_when_mapped(): void
    {
        $source = new LazyItemCollection([new Item(2, 'two')]);

        $mapped = $source->map(static fn(Item $item) => $item->value);

        $this->assertEquals(['two'], $mapped->toArray());
    }

    #[Test]
    #[DoesNotPerformAssertions]
    public function items_can_be_of_simple_type(): void
    {
        new LazyMixedTypeCollection([1, 'string', new Item()]);
    }

    #[Test]
    public function items_of_simple_type_can_be_rejected(): void
    {
        $this->expectException(InvalidArgumentException::class);
        /** @phpstan-ignore argument.type */
        new LazyMixedTypeCollection([true]);
    }
}
