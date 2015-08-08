<?php

namespace Rubicon\Collection\Comparison;

class DiffTest extends \PHPUnit_Framework_TestCase
{
    public function testAccessor()
    {
        $diff = new Diff('original', 'modified');
        $this->assertSame('original', $diff->getOriginal());
        $this->assertSame('modified', $diff->getModified());
    }
}