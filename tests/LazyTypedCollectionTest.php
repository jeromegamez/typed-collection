<?php

namespace Gamez\Illuminate\Support\Tests;

use DateTime;
use Gamez\Illuminate\Support\LazyTypedCollection;
use Illuminate\Support\Collection;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use Illuminate\Support\LazyCollection;

class LazyTypedCollectionTest extends TestCase
{
    /** @var LazyDateTimeCollection */
    private $collection;

    protected function setUp()
    {
        if (!class_exists(LazyCollection::class)) {
            $this->markTestSkipped();
        }

        $this->collection = new LazyDateTimeCollection();
    }

    /** @test */
    public function it_cannot_be_created_with_an_unsupported_type_of_item()
    {
        $this->expectException(InvalidArgumentException::class);
        new LazyDateTimeCollection([new DateTime(), 'string', new DateTime()]);
    }

    /** @test */
    public function it_can_be_created_with_supported_types()
    {
        new LazyDateTimeCollection([new DateTime(), new DateTime(), new DateTime()]);
        $this->addToAssertionCount(1);
    }

    /** @test */
    public function it_can_be_untyped()
    {
        $untyped = $this->collection->untype();

        $this->assertInstanceOf(LazyCollection::class, $untyped);
        $this->assertNotInstanceOf(LazyDateTimeCollection::class, $untyped);
        $this->assertNotInstanceOf(LazyTypedCollection::class, $untyped);
    }

    /** @test */
    public function it_can_be_converted_to_an_array()
    {
        $collection = new LazyDateTimeCollection([new DateTime(), new DateTime()]);

        $this->assertCount(2, $collection->toArray());
    }

    /**
     * @test
     * @see https://github.com/jeromegamez/typed-collection/issues/2
     */
    public function it_works_with_items_that_themselves_are_arrayable()
    {
        $collection = new LazyArrayableItemCollection([new ArrayableItem()]);
        $this->assertCount(1, $collection->toArray());
    }

    /**
     * @test
     * @see https://github.com/jeromegamez/typed-collection/issues/4
     */
    public function items_can_be_plucked()
    {
        $collection = new LazyArrayableItemCollection([
            new ArrayableItem(1, 'a'),
            new ArrayableItem(2, 'b'),
            new ArrayableItem(3, 'c')
        ]);

        $this->assertEquals([null, null, null], $collection->pluck('name')->toArray());
        $this->assertEquals([1, 2, 3], $collection->pluck('id')->toArray());
    }
}
