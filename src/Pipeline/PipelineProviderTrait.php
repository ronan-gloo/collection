<?php

namespace Rubicon\Collection\Pipeline;

trait PipelineProviderTrait
{
    /**
     * @param callable[] $callbacks
     *
     * @return PipelineInterface
     */
    public function pipe(...$callbacks)
    {
        $instance = $this;
        foreach ($callbacks as $callback) {
            $instance = new Pipeline($instance, $callback);
        }

        return $instance;
    }
}