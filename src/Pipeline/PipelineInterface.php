<?php

namespace Rubicon\Collection\Pipeline;

interface PipelineInterface
{
    /**
     * @param callable[] $callbacks
     *
     * @return Pipeline
     */
    public function pipe(...$callbacks);

    /**
     * @return mixed
     */
    public function execute();
}