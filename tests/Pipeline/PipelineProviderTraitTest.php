<?php

namespace Rubicon\Collection\Pipeline;
use Rubicon\Collection\Collection;
use Rubicon\Collection\CollectionInterface;

/**
 * @group
 */
class PipelineProviderTraitTest extends \PHPUnit_Framework_TestCase
{
    public function testPipe()
    {
        $instance = new PipelineProviderTraitStub;
        $instance->output = $this->getMock(CollectionInterface::class);
        $pipeline = $instance->pipe(function(){
            return 'output';
        });

        $this->assertInstanceOf(PipelineInterface::class, $pipeline);
        $this->assertSame('output', $pipeline->execute());
    }
}
class PipelineProviderTraitStub implements PipelineInterface
{
    use PipelineProviderTrait;
    public $output;
    public function execute() { return $this->output; }
}
