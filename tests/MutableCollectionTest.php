<?php

namespace Rubicon\Collection;


use Rubicon\Collection\Constraint\IsTypeOf;
use Rubicon\Collection\Exception\ValidationException;

class MutableCollectionTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var MutableCollection
     */
    protected $instance;

    public function setUp()
    {
        $this->instance = new MutableCollection();
    }

    public function testSetElement()
    {
        $this->assertSame($this->instance, $this->instance->set('key', 'val'));
        $this->assertTrue($this->instance->has('key'));
        $this->assertSame('val', $this->instance->get('key'));

    }

    public function testAddElement()
    {
        $this->assertSame($this->instance, $this->instance->add('val'));
        $this->assertTrue($this->instance->has(0));
        $this->assertSame('val', $this->instance->get(0));
    }

    public function testRemoveElementsStrict()
    {
        $this->instance
            ->add('val')
            ->add('val')
            ->add('val')
            ->add('toto')
        ;

        $this->assertSame($this->instance, $this->instance->remove('val'));
        $this->assertSame([3 => 'toto'], $this->instance->get());
    }

    public function testRemoveElementsNonStrict()
    {
        $this->instance
            ->add('1')
            ->add(1)
        ;

        $this->assertSame($this->instance, $this->instance->remove(1.0, false));
        $this->assertCount(0, $this->instance);
    }

    public function testDeleteKey()
    {
        $this->instance
            ->add('one')
            ->add('two')
        ;

        $this->assertSame($this->instance, $this->instance->delete(1));
        $this->assertSame([0 => 'one'], $this->instance->get());
    }

    public function testClearElements()
    {
        $this->instance
            ->add('one')
            ->add('two')
        ;

        $this->assertSame($this->instance, $this->instance->clear());
        $this->assertCount(0, $this->instance);
    }

    public function testReplaceElementsStrict()
    {
        $result = $this->instance
            ->add(1)
            ->add('1')
            ->replace(1, 2)
            ->get();

        $this->assertSame([2, '1'], $result);
    }

    public function testReplaceElementsNonStrict()
    {
        $result = $this->instance
            ->add(1)
            ->add('1')
            ->replace(1, 2, false)
            ->get();

        $this->assertSame([2, 2], $result);
    }

    public function testExchangeWith()
    {
        $this->assertSame([1, 2], $this->instance->exchangeWith([1, 2])->get());
        $this->assertSame([1, 2], $this->instance->exchangeWith(new Collection([1, 2]))->get());

        $this->setExpectedException(ValidationException::class);
        $instance = new MutableCollection([], new IsTypeOf('string'));
        $instance->exchangeWith([1]);
    }

    public function testAccept()
    {
        $this->assertTrue($this->instance->accept('test'), 'accepted by default');

        $collection = new MutableCollection([], new IsTypeOf('string'));
        $this->assertTrue($collection->accept('i am a string'));
        $this->assertFalse($collection->accept(123));
    }
}