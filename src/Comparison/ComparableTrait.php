<?php

namespace Rubicon\Collection\Comparison;

use Rubicon\Collection\CollectionInterface;
use Rubicon\Collection\Exception\RuntimeException;

trait ComparableTrait
{
    /**
     * {@inheritdoc}
     */
    public function compareTo(CollectionInterface $collection)
    {
        if (! $this instanceof CollectionInterface) {
            throw new RuntimeException(
                get_class($this) . ' instance cannot be compared, expecting ' . CollectionInterface::class
            );
        }
        return (new Comparator)->compare($this, $collection);
    }
}