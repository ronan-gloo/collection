<?php

namespace Rubicon\Collection\Constraint;

class IsTypeOfTest extends \PHPUnit_Framework_TestCase
{
    public function testIsOneOfTheGivenTypes()
    {
        $instance = new IsTypeOf(['string', 'object']);
        $this->assertTrue($instance('toto'));
        $this->assertTrue($instance(new \stdClass()));
        $this->assertFalse($instance(123));
    }
}