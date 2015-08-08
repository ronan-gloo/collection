<?php

namespace Rubicon\Collection\Comparison;

use Rubicon\Collection\CollectionInterface;

interface CollectionCompareInterface
{
    /**
     * Return an associative array of elements that are present in original collection,
     * but removed from the modified one.
     *
     * @return CollectionInterface
     */
    public function getRemoved();

    /**
     * Return an associative array of elements that are present in modified collection,
     * but not in the original one.
     *
     * @return CollectionInterface
     */
    public function getAdded();

    /**
     * Return an associative array of elements that are present in both collection,
     * but modified from the modified one.
     *
     * @return CollectionInterface|DiffInterface[]   A collection of Diff objects
     */
    public function getModified();
}