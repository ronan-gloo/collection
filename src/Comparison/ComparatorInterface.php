<?php

namespace Rubicon\Collection\Comparison;

use Rubicon\Collection\CollectionInterface;
use Rubicon\Collection\Exception\RuntimeException;

interface ComparatorInterface
{
    /**
     * Compare two collection internal elements
     *
     * @param CollectionInterface $form
     * @param CollectionInterface $to
     *
     * @return ComparisonResult
     * @throws RuntimeException If the comparison cannot be executed
     */
    public function compare(CollectionInterface $form, CollectionInterface $to);
}