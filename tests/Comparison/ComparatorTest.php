<?php

namespace Rubicon\Collection\Comparison;

use Rubicon\Collection\Collection;
use Rubicon\Collection\Exception\RuntimeException;
use Rubicon\Collection\MutableCollection;

class ComparatorTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Comparator
     */
    private $instance;

    public function setUp()
    {
        $this->instance = new Comparator();
    }

    public function testCannotCompareTheSameCollection()
    {
        $this->setExpectedException(RuntimeException::class);
        $collection = new Collection();
        $this->instance->compare($collection, $collection);
    }

    public function testGetModifiedElements()
    {
        $original = new MutableCollection(['hello' => 'world', 'world' => 'hello']);
        $modified = clone $original;
        $modified->set('hello', 'none');

        $comparison = $this->instance->compare($original, $modified);
        $this->assertInstanceOf(ComparisonResult::class, $comparison);

        $diff = $comparison->diff('hello');
        $this->assertInstanceOf(Diff::class, $diff);

        $this->assertSame('world', $diff->original());
        $this->assertSame('none', $diff->modified());
    }

    public function testGetRemovedElements()
    {
        $original = new MutableCollection(['hello' => 'world', 'world' => 'hello']);
        $modified = clone $original;
        $modified->delete('hello');

        $comparison = $this->instance->compare($original, $modified)->missing();
        $this->assertSame('world', $comparison->get('hello'));
    }

    public function testGetAddedElements()
    {
        $original = new MutableCollection(['hello' => 'world']);
        $modified = clone $original;
        $modified->set('world', 'hello');

        $comparison = $this->instance->compare($original, $modified)->additional();
        $this->assertSame('hello', $comparison->get('world'));
    }
}