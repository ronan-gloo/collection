<?php

namespace Rubicon\Collection;

use Rubicon\Collection\Exception\RuntimeException;

class CollectionCompareTest extends \PHPUnit_Framework_TestCase
{
    public function testCannotCompareTheSameCollection()
    {
        $this->setExpectedException(RuntimeException::class);
        $collection = new Collection();
        new CollectionCompare($collection, $collection);
    }

    public function testGetModifiedElements()
    {
        $original = new MutableCollection(['hello' => 'world', 'world' => 'hello']);
        $modified = clone $original;
        $modified->set('hello', 'none');

        $comparison = (new CollectionCompare($original, $modified))->getModified();
        $this->assertInstanceOf(CollectionInterface::class, $comparison);

        $diff = $comparison->get('hello');
        $this->assertInstanceOf(Diff::class, $diff);

        $this->assertSame('world', $diff->getOriginal());
        $this->assertSame('none', $diff->getModified());
    }

    public function testGetRemovedElements()
    {
        $original = new MutableCollection(['hello' => 'world', 'world' => 'hello']);
        $modified = clone $original;
        $modified->delete('hello');

        $comparison = (new CollectionCompare($original, $modified))->getRemoved();
        $this->assertSame('world', $comparison->get('hello'));
    }

    public function testGetAddedElements()
    {
        $original = new MutableCollection(['hello' => 'world']);
        $modified = clone $original;
        $modified->set('world', 'hello');

        $comparison = (new CollectionCompare($original, $modified))->getAdded();
        $this->assertSame('hello', $comparison->get('world'));
    }

    public function testGetAllOperations()
    {
        $original = new MutableCollection(['modify' => 'mod', 'delete' => 'deleted']);
        $modified = clone $original;
        $modified->set('add', 'added');
        $modified->delete('delete');
        $modified->set('modify', 'modified');

        $comparison = (new CollectionCompare($original, $modified))->getOperations();
        $this->assertSame('modified', $comparison->get('modified')->get('modify')->getModified());
        $this->assertSame('deleted', $comparison->get('removed')->get('delete'));
        $this->assertSame('added', $comparison->get('added')->get('add'));
    }
}