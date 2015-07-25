<?php

namespace Rubicon\Collection\Constraint;

use Rubicon\Collection\CollectionInterface;

class IsIndex
{
    /**
     * @param integer             $index
     * @param CollectionInterface $collection
     *
     * @return bool
     */
    public function __invoke($index, CollectionInterface $collection)
    {
        return is_numeric($index) && $index <= $collection->count();
    }
}