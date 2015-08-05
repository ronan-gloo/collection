<?php

namespace Rubicon\Collection;

use Rubicon\Collection\Exception\ValidationException;

class CollectionTest extends \PHPUnit_Framework_TestCase
{
    public function testConstructWithElementValidation()
    {
        $this->setExpectedException(ValidationException::class);
        new Collection([123, '123'], [$this, 'isInt']);
    }

    public function testConstructWithKeyValidation()
    {
        $this->setExpectedException(ValidationException::class);
        new Collection([123, 'hello' => 123], null, [$this, 'isInt']);
    }

    public function isInt($val)
    {
        return is_int($val);
    }

    public function testGet()
    {
        $instance = new Collection();
        $this->assertSame([], $instance->get());

        $instance = new Collection(['item' => 'data']);
        $this->assertSame(['item' => 'data'], $instance->get());
        $this->assertSame('data', $instance->get('item'));
        $this->assertNull($instance->get('reference'));
    }

    public function testHas()
    {
        $instance = new Collection(['one' => null, 'two' => 2]);
        $this->assertTrue($instance->has('one'));
        $this->assertTrue($instance->has('two'));
        $this->assertFalse($instance->has('three'));
    }

    public function testMap()
    {
        $instance = new Collection(['item' => 'data']);
        $expected = $instance->map(function ($item) {
            return $item . '-extended';
        });

        $this->assertInstanceOf(Collection::class, $expected);
        $this->assertNotSame($instance, $expected);
        $this->assertSame('data-extended', $expected->get('item'));
    }

    public function testReduce()
    {
        $instance = new Collection([1, 2, 3]);
        $expected = $instance->reduce(function($carry, $item){
            return $carry + $item;
        });
        $this->assertSame(6, $expected);
    }

    public function testTake()
    {
        $instance = new Collection(['one' => 'one', 'two' => 'two', 'three' => 'three']);
        $result = $instance->take(2);

        $this->assertInstanceOf(Collection::class, $result);
        $this->assertSame(['one' => 'one', 'two' => 'two'], $result->get());

        $result = $instance->take(1, 1);
        $this->assertSame(['two' => 'two'], $result->get());
    }

    public function testUnique()
    {
        $obj1 = new \stdClass();
        $obj1->id = 1;
        $obj1->data = 'a';

        $obj2 = new \stdClass();
        $obj2->id = 1;
        $obj2->data = 'b';

        $obj3 = new \stdClass();
        $obj3->id = 2;
        $obj3->data = 'c';

        $obj4 = new \stdClass();
        $obj4->id = '2';
        $obj4->data = 'd';

        $collection = new Collection([$obj1, $obj2, $obj3, $obj4]);
        $result = $collection->distinct(function($obj){
            return $obj->id;
        });

        $this->assertSame([0 => $obj1, 2 => $obj3, 3 => $obj4], $result->get(), 'uniqueness is based on strict callback value');

        $result = $collection->distinct();
        $this->assertSame([$obj1, $obj2, $obj3, $obj4], $result->get(), 'default flag is sort regular');

        $this->setExpectedException(\InvalidArgumentException::class);
        $collection->distinct('not valid argument');
    }

    public function testFilter()
    {
        $result = (new Collection([1, 2]))->filter(function($val) {
            return $val === 1;
        });

        $this->assertSame([1], $result->get());
    }

    public function testReject()
    {
        $result = (new Collection([1, 2]))->reject(function($val) {
            return $val !== 1;
        });

        $this->assertSame([1], $result->get());
    }

    public function testContains()
    {
        $this->assertTrue((new Collection(['one', 'two']))->contains('two'));
        $this->assertFalse((new Collection(['1']))->contains(1));
        $this->assertTrue((new Collection(['1']))->contains(1, false));
    }

    public function testAgreggateIterator()
    {
        $collection = new Collection([1, 2]);

        $this->assertInstanceOf(\IteratorAggregate::class, $collection);
        $this->assertInstanceOf(\Generator::class, $collection->getIterator());

        foreach ($collection as $key => $val) {
            $this->assertSame($key, $collection->indexOf($val));
            $this->assertSame($val, $collection->get($key));
        }
    }

    public function testIsCountable()
    {
        $this->assertCount(2, new Collection([1, 2]));
    }

    public function testToImmutable()
    {
        $elements = [1, 3];
        $collection = (new MutableCollection($elements))->toImmutable();

        $this->assertInstanceOf(Collection::class, $collection);
        $this->assertSame($elements, $collection->get());
    }

    public function testGetKeys()
    {
        $this->assertSame(
            ['one', 0],
            (new Collection(['one' => 1, 2]))->keys()->get()
        );
    }

    public function testFirstAndLast()
    {
        $collection = new Collection([1, 2, 3]);
        $this->assertSame(1, $collection->first());
        $this->assertSame(3, $collection->last());
    }
}