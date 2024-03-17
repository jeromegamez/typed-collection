<?php

namespace Gamez\Illuminate\Support\Tests;

use DateTime;
use DateTimeInterface;
use Gamez\Illuminate\Support\Tests\ArrayableItem;
use Gamez\Illuminate\Support\TypedCollection;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

class HelpersTest extends TestCase
{
    /** @test */
    public function it_cannot_be_created_with_an_unsupported_type_of_item()
    {
        $this->expectException(InvalidArgumentException::class);
        typedCollect([new DateTime(), 'string', new DateTime()], DateTimeInterface::class);
    }

    /** @test */
    public function it_can_be_created_with_supported_types()
    {
        $typedCollection = typedCollect([new DateTime(), new DateTime()], DateTimeInterface::class);
        $this->assertInstanceOf(TypedCollection::class, $typedCollection);
        $this->addToAssertionCount(1);
    }

    /** @test */
    public function it_can_accept_an_array_of_types()
    {
        $typedCollection = typedCollect([new DateTime(), new ArrayableItem()], [DateTimeInterface::class, ArrayableItem::class]);
        $this->assertInstanceOf(TypedCollection::class, $typedCollection);
        $this->addToAssertionCount(1);
    }
}
