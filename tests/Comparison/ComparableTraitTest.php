<?php

namespace Rubicon\Collection\Comparison;

use Rubicon\Collection\Collection;
use Rubicon\Collection\CollectionInterface;
use Rubicon\Collection\Exception\RuntimeException;

class ComparableTraitTest extends \PHPUnit_Framework_TestCase
{
    public function testTraitMustBeAnInstanceOfCollectionInterface()
    {
        $instance = $this->getObjectForTrait(ComparableTrait::class);
        $this->setExpectedException(RuntimeException::class);
        $instance->compareTo(
            $this->getMock(CollectionInterface::class)
        );
    }

    public function testTraitCompare()
    {
        $instance = $this->getMockForAbstractClass(ComparableTraitStub::class);
        $comparison  = $instance->compareTo(new Collection());

        $this->assertInstanceOf(ComparisonResult::class, $comparison);
    }
}

abstract class ComparableTraitStub implements CollectionInterface
{
    use ComparableTrait;
    public function getIterator()
    {
        return new \ArrayIterator([]);
    }
}
