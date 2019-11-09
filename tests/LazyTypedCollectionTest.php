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
}
