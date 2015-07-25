<?php

namespace Rubicon\Collection\Constraint;

class IsEqualToTest extends \PHPUnit_Framework_TestCase
{
    public function testWithStrictAndNoStrict()
    {
        $instance = new IsEqualTo('123');
        $this->assertFalse($instance(123));

        $instance = new IsEqualTo('123', false);
        $this->assertTrue($instance(123));
    }
}