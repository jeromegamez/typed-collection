<?php

namespace Gamez\Illuminate\Support\Tests;

use Gamez\Illuminate\Support\TypedCollection;
use Illuminate\Support\Collection;
use PHPUnit\Framework\TestCase;

class TypedCollectionTest extends TestCase
{
    /** @test */
    public function it_only_accepts_items_of_a_given_type()
    {
        $items = [new \DateTime(), new \DateTimeImmutable()];

        $collection = new class($items) extends TypedCollection {
            protected static $allowedTypes = [\DateTimeInterface::class];
        };

        $collection->push(new \DateTime());
        $collection->prepend(new \DateTime());
        $collection->put(999, new \DateTime());

        $this->assertCount(5, $collection);
    }

    /** @test */
    public function it_does_not_accept_an_unsupported_type()
    {
        $items = [new \stdClass()];

        $this->expectException(\InvalidArgumentException::class);

        new class($items) extends TypedCollection {
            protected static $allowedTypes = [\DateTimeInterface::class];
        };
    }

    /** @test */
    public function it_returns_a_normal_collection_when_mapped_with_invalid_values()
    {
        $items = [new \DateTime()];

        $collection = new class($items) extends TypedCollection {
            protected static $allowedTypes = [\DateTimeInterface::class];
        };

        $dateStrings = $collection->map(function (\DateTime $dt) { return $dt->format(\DateTime::ATOM); });

        $this->assertInstanceOf(Collection::class, $dateStrings);
        $this->assertNotInstanceOf(TypedCollection::class, $dateStrings);
    }

    /** @test */
    public function it_can_be_untyped()
    {
        $this->assertNotInstanceOf(TypedCollection::class, (new TypedCollection())->untype());
    }
}
