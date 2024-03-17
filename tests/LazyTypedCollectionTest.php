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
    /** @var LazyDateTimeCollection */
    private $collection;

    protected function setUp(): void
    {
        if (!class_exists(LazyCollection::class)) {
            $this->markTestSkipped();
        }

        $this->collection = new LazyDateTimeCollection();
    }

    #[Test]
    public function it_cannot_be_created_with_an_unsupported_type_of_item(): void
    {
        $this->expectException(InvalidArgumentException::class);
        new LazyDateTimeCollection([new DateTime(), 'string', new DateTime()]);
    }

    #[Test]
    #[DoesNotPerformAssertions]
    public function it_can_be_created_with_supported_types(): void
    {
        new LazyDateTimeCollection([new DateTime(), new DateTime(), new DateTime()]);
    }

    #[Test]
    public function it_can_be_untyped(): void
    {
        $untyped = $this->collection->untype();

        $this->assertInstanceOf(LazyCollection::class, $untyped);
        $this->assertNotInstanceOf(LazyDateTimeCollection::class, $untyped);
        $this->assertNotInstanceOf(LazyTypedCollection::class, $untyped);
    }

    #[Test]
    public function it_can_be_converted_to_an_array(): void
    {
        $collection = new LazyDateTimeCollection([new DateTime(), new DateTime()]);

        $this->assertCount(2, $collection->toArray());
    }

    /**
     * @see https://github.com/jeromegamez/typed-collection/issues/2
     */
    #[Test]
    public function it_works_with_items_that_themselves_are_arrayable(): void
    {
        $collection = new LazyArrayableItemCollection([new ArrayableItem()]);
        $this->assertCount(1, $collection->toArray());
    }

    /**
     * @see https://github.com/jeromegamez/typed-collection/issues/4
     */
    #[Test]
    public function items_can_be_plucked(): void
    {
        $collection = new LazyArrayableItemCollection([
            new ArrayableItem(1, 'a'),
            new ArrayableItem(2, 'b'),
            new ArrayableItem(3, 'c')
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
        $source = new LazyDateTimeCollection([
            new DateTimeImmutable('2022-04-25'),
        ]);

        $mapped = $source->map(static fn($item) => $item->format('Y-m-d'));

        $this->assertEquals(['2022-04-25'], $mapped->toArray());
    }
}
