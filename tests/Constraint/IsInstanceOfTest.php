<?php

namespace Rubicon\Collection\Constraint;

class IsInstanceOfTest extends \PHPUnit_Framework_TestCase
{
    public function testIsAtLeastAnInstanceOf()
    {
        $constraint = new IsInstanceOf('ArrayAccess');
        $this->assertTrue($constraint(new \ArrayObject()));

        $constraint = new IsInstanceOf(['Iterator', 'Countable']);
        $this->assertTrue($constraint(new \ArrayObject()));

        $constraint = new IsInstanceOf(['Iterator']);
        $this->assertFalse($constraint(new \ArrayObject()));
    }
}
