<?php

namespace Rubicon\Collection\Comparison;

interface DiffInterface
{
    /**
     * @return mixed
     */
    public function getOriginal();

    /**
     * @return mixed
     */
    public function getModified();
}