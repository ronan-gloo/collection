<?php

namespace Rubicon\Collection\Pipeline;

use Rubicon\Collection\CollectionInterface;

class PipelineTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Pipeline
     */
    protected $instance;

    /**
     * @dataProvider invalidClassDataProvider
     * @expectedException \InvalidArgumentException
     */
    public function testConstructorWithInvalidClass($class)
    {
        $this->instance = new Pipeline($class, 'is_string');
    }

    public function invalidClassDataProvider()
    {
        return [
            [new \stdClass()],
            ['string'],
            [123]
        ];
    }

    public function testPipeWithCollection()
    {
        $collection = $this->getMock(CollectionInterface::class);
        $expected   = null;
        $pipeline   = new Pipeline($collection, function($argument) use(&$expected) {
            $expected = $argument;
            return 'executed';
        });

        $result = $pipeline->execute();
        $this->assertSame($collection, $expected);
        $this->assertSame('executed', $result);
    }

    public function testPipeWithPipelineInterface()
    {
        $collection = $this->getMock(CollectionInterface::class);
        $pipeline   = $this->getMock(PipelineInterface::class);
        $pipeline
            ->expects($this->once())
            ->method('execute')
            ->willReturn($collection)
        ;

        $expected = null;
        $instance = new Pipeline($pipeline, function($argument) use(&$expected) {
            $expected = $argument;
            return 'executed';
        });

        $result = $instance->execute();
        $this->assertSame($collection, $expected);
        $this->assertSame('executed', $result);
    }

    /**
     * @expectedException \UnexpectedValueException
     */
    public function testPipeWithInvalidPipelineInterfaceOutput()
    {
        $pipeline   = $this->getMock(PipelineInterface::class);
        $pipeline
            ->expects($this->once())
            ->method('execute')
            ->willReturn(new \stdClass())
        ;

        $instance = new Pipeline($pipeline, 'is_string');
        $instance->execute();
    }
}
