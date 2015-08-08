<?php

namespace Rubicon\Collection\Comparison;

interface DiffInterface
{
    /**
     * @return mixed
     */
    public function original();

    /**
     * @return mixed
     */
    public function modified();
}