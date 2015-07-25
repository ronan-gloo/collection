<?php

namespace Rubicon\Collection\Pipeline;

trait PipelineProviderTrait
{
    /**
     * @param callable $callback
     *
     * @return PipelineInterface
     */
    public function pipe(callable $callback)
    {
        $instance = $this;
        foreach (func_get_args() as $callback) {
            $instance = new Pipeline($instance, $callback);
        }

        return $instance;
    }
}