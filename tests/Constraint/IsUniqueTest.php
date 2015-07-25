<?php

namespace Rubicon\Collection\Constraint;

use Rubicon\Collection\CollectionInterface;

class IsUniqueTest extends \PHPUnit_Framework_TestCase
{
    public function testItCheckInTheCollectionKeys()
    {
        $instance   = new IsUnique(IsUnique::VALIDATE_KEY);
        $collection = $this->getMock(CollectionInterface::class);
        $collection
            ->expects($this->once())
            ->method('has')
            ->with($value = 'toto')
            ->willReturn(true);

        $this->assertFalse($instance($value, $collection));
    }

    public function testItCheckInTheCollectionElements()
    {
        $instance   = new IsUnique(IsUnique::VALIDATE_ELEMENT);
        $collection = $this->getMock(CollectionInterface::class);
        $collection
            ->expects($this->once())
            ->method('contains')
            ->with($value = 'toto')
            ->willReturn(true);

        $this->assertFalse($instance($value, $collection));
    }
}
