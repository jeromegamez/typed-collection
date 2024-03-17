<?php

namespace Gamez\Illuminate\Support\Tests;

use DateTime;
use DateTimeImmutable;
use Gamez\Illuminate\Support\TypedCollection;
use Illuminate\Support\Collection;
use InvalidArgumentException;
use PHPUnit\Framework\Attributes\DoesNotPerformAssertions;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

class TypedCollectionTest extends TestCase
{
    /** @var DateTimeCollection */
    private $collection;

    protected function setUp(): void
    {
        $this->collection = new DateTimeCollection();
    }

    #[Test]
    public function it_cannot_be_created_with_an_unsupported_type_of_item(): void
    {
        $this->expectException(InvalidArgumentException::class);
        new DateTimeCollection([new DateTime(), 'string', new DateTime()]);
    }

    #[Test]
    #[DoesNotPerformAssertions]
    public function it_can_be_created_with_supported_types(): void
    {
        new DateTimeCollection([new DateTime(), new DateTime(), new DateTime()]);
    }

    #[Test]
    #[DoesNotPerformAssertions]
    public function a_supported_value_can_be_added(): void
    {
        $this->collection->add(new DateTime());
    }

    #[Test]
    public function an_unsupported_value_can_not_be_added(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->collection->add('string');
    }

    #[Test]
    #[DoesNotPerformAssertions]
    public function a_supported_value_can_be_prepended(): void
    {
        $this->collection->prepend(new DateTime());
    }

    #[Test]
    public function an_unsupported_value_can_not_be_prepended(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->collection->prepend('string');
    }

    #[Test]
    #[DoesNotPerformAssertions]
    public function a_supported_value_can_be_pushed(): void
    {
        $this->collection->push(new DateTime());
    }

    #[Test]
    public function an_unsupported_value_can_not_be_pushed(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->collection->push('string');
    }

    #[Test]
    #[DoesNotPerformAssertions]
    public function a_supported_value_can_be_put(): void
    {
        $this->collection->put('key', new DateTime());
    }

    #[Test]
    public function an_unsupported_value_can_not_be_put(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->collection->put('key', 'string');
    }

    #[Test]
    public function it_can_be_untyped(): void
    {
        $untyped = $this->collection->untype();

        $this->assertInstanceOf(Collection::class, $untyped);
        $this->assertNotInstanceOf(DateTimeCollection::class, $untyped);
        $this->assertNotInstanceOf(TypedCollection::class, $untyped);
    }

    #[Test]
    public function it_can_be_converted_to_an_array(): void
    {
        $this->collection->push(new DateTime());
        $this->collection->push(new DateTime());

        $this->assertCount(2, $this->collection->toArray());
    }

    /**
     * @see https://github.com/jeromegamez/typed-collection/issues/2
     */
    #[Test]
    public function it_works_with_items_that_themselves_are_arrayable(): void
    {
        $collection = new ArrayableItemCollection();
        $collection->push(new ArrayableItem());
        $this->assertCount(1, $collection->toArray());
    }

    /**
     * @see https://github.com/jeromegamez/typed-collection/issues/7
     */
    #[Test]
    public function it_accepts_items_to_be_pushed(): void
    {
        $collection = new ArrayableItemCollection();

        $collection->push(...[new ArrayableItem(), new ArrayableItem()]);
        $this->assertCount(2, $collection);

        $collection->push(new ArrayableItem(), new ArrayableItem());
        $this->assertCount(4, $collection);
    }

    /**
     * @see https://github.com/jeromegamez/typed-collection/issues/4
     */
    #[Test]
    public function items_can_be_plucked(): void
    {
        $collection = new ArrayableItemCollection([
            new ArrayableItem(1, 'a'),
            new ArrayableItem(2, 'b'),
            new ArrayableItem(3, 'c'),
        ]);

        $this->assertEquals([null, null, null], $collection->pluck('name')->toArray());
        $this->assertEquals([1, 2, 3], $collection->pluck('id')->toArray());
    }

    #[Test]
    public function it_returns_keys(): void
    {
        $collection = new ArrayableItemCollection();
        $collection->put('a' ,new ArrayableItem());
        $collection->put('b', new ArrayableItem());

        $this->assertEquals(['a', 'b'], $collection->keys()->toArray());
    }

    /**
     * @see https://github.com/jeromegamez/typed-collection/issues/11
     */
    #[Test]
    public function items_are_untyped_when_mapped(): void
    {
        $source = new DateTimeCollection([
            new DateTimeImmutable('2022-04-25'),
        ]);

        $mapped = $source->map(static fn($item) => $item->format('Y-m-d'));

        $this->assertEquals(['2022-04-25'], $mapped->toArray());
    }
}
