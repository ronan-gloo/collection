<?php

namespace Rubicon\Collection\Pipeline;

interface PipelineInterface
{
    /**
     * Pipe one or more callbacks
     *
     * @param callable $callback
     *
     * @return Pipeline
     */
    public function pipe(callable $callback);

    /**
     * @return mixed
     */
    public function execute();
}