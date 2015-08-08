<?php

namespace Rubicon\Collection\Comparison;

use Rubicon\Collection\Collection;

class ComparisonResultTest extends \PHPUnit_Framework_TestCase
{
    public function testGetMissing()
    {
        $missing  = new Collection(['modified' => 'yes']);
        $diff     = clone $missing;
        $added    = clone $missing;
        $instance = new ComparisonResult($missing, $diff, $added);

        $this->assertSame($missing, $instance->missing());
        $this->assertSame($diff, $instance->diff());
        $this->assertSame($added, $instance->additional());

        $this->assertSame('yes', $instance->missing('modified'));
        $this->assertSame('yes', $instance->diff('modified'));
        $this->assertSame('yes', $instance->additional('modified'));
    }
}
