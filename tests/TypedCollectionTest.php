<?php

namespace Gamez\Illuminate\Support\Tests;

use DateTime;
use Gamez\Illuminate\Support\TypedCollection;
use Illuminate\Support\Collection;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

class TypedCollectionTest extends TestCase
{
    /** @var DateTimeCollection */
    private $collection;

    protected function setUp()
    {
        $this->collection = new DateTimeCollection();
    }

    /** @test */
    public function it_cannot_be_created_with_an_unsupported_type_of_item()
    {
        $this->expectException(InvalidArgumentException::class);
        new DateTimeCollection([new DateTime(), 'string', new DateTime()]);
    }

    /** @test */
    public function it_can_be_created_with_supported_types()
    {
        new DateTimeCollection([new DateTime(), new DateTime(), new DateTime()]);
        $this->addToAssertionCount(1);
    }

    /** @test */
    public function a_supported_value_can_be_added()
    {
        $this->collection->add(new DateTime());
        $this->addToAssertionCount(1);
    }

    /** @test */
    public function an_unsupported_value_can_not_be_added()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->collection->add('string');
    }

    /** @test */
    public function a_supported_value_can_be_prepended()
    {
        $this->collection->prepend(new DateTime());
        $this->addToAssertionCount(1);
    }

    /** @test */
    public function an_unsupported_value_can_not_be_prepended()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->collection->prepend('string');
    }

    /** @test */
    public function a_supported_value_can_be_pushed()
    {
        $this->collection->push(new DateTime());
        $this->addToAssertionCount(1);
    }

    /** @test */
    public function an_unsupported_value_can_not_be_pushed()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->collection->push('string');
    }

    /** @test */
    public function a_supported_value_can_be_put()
    {
        $this->collection->put('key', new DateTime());
        $this->addToAssertionCount(1);
    }

    /** @test */
    public function an_unsupported_value_can_not_be_put()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->collection->put('key', 'string');
    }

    /** @test */
    public function it_can_be_untyped()
    {
        $untyped = $this->collection->untype();

        $this->assertInstanceOf(Collection::class, $untyped);
        $this->assertNotInstanceOf(DateTimeCollection::class, $untyped);
        $this->assertNotInstanceOf(TypedCollection::class, $untyped);
    }
}
