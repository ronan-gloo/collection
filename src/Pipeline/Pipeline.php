<?php

namespace Rubicon\Collection\Pipeline;

use InvalidArgumentException;
use Rubicon\Collection\CollectionInterface;

/**
 * Allow to execute reusable macros against collections.
 */
class Pipeline implements PipelineInterface
{
    use PipelineProviderTrait;

    /**
     * @var CollectionInterface
     */
    private $collection;

    /**
     * @var callable
     */
    private $callback;

    /**
     * @param          $collectionOrPipeline
     * @param callable $callback
     *
     * @throws InvalidArgumentException
     */
    public function __construct($collectionOrPipeline, callable $callback)
    {
        if (! $collectionOrPipeline instanceof PipelineInterface && ! $collectionOrPipeline instanceof CollectionInterface) {
            throw new InvalidArgumentException('expects Collection or Pipeline');
        }
        $this->collection = $collectionOrPipeline;
        $this->callback   = $callback;
    }

    /**
     * @return mixed
     */
    public function execute()
    {
        if ($this->collection instanceof PipelineInterface) {
            $collection = $this->collection->execute();
            if (! $collection instanceof CollectionInterface) {
                throw new \UnexpectedValueException('Expecting an instance of ' . CollectionInterface::class);
            }
        } else {
            $collection = $this->collection;
        }

        return call_user_func($this->callback, $collection);
    }
}