<?php

namespace Rubicon\Collection\Comparison;

use Rubicon\Collection\CollectionInterface;
use Rubicon\Collection\Exception\RuntimeException;

interface ComparableInterface
{
    /**
     * @param CollectionInterface $collection
     *
     * @return ComparisonResult
     * @throws RuntimeException If the comparison cannot be executed
     */
    public function compareTo(CollectionInterface $collection);
}