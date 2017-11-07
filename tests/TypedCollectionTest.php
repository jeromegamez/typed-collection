<?php

namespace Gamez\Illuminate\Support\Tests;

use DateTime;
use DateTimeInterface;
use Gamez\Illuminate\Support\TypedCollection;
use Illuminate\Support\Collection;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

class TypedCollectionTest extends TestCase
{
    /**
     * @var TypedCollection
     */
    private $collection;

    protected function setUp()
    {
        $this->collection = new class extends TypedCollection {
            protected static $allowedTypes = [DateTimeInterface::class];
        };
    }

    /** @test */
    public function it_only_accepts_items_of_a_given_type()
    {
        $this->collection->push(new DateTime());
        $this->collection->prepend(new DateTime());
        $this->collection->put(999, new DateTime());

        $this->assertCount(3, $this->collection);
    }

    /** @test */
    public function it_does_not_accept_an_unsupported_type()
    {
        $this->expectException(InvalidArgumentException::class);

        $this->collection->push(new \stdClass());
    }

    /** @test */
    public function it_can_be_untyped()
    {
        $untyped = $this->collection->untype();

        $this->assertInstanceOf(Collection::class, $untyped);
        $this->assertNotInstanceOf(TypedCollection::class, $untyped);
    }
}
