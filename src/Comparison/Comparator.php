<?php

namespace Rubicon\Collection\Comparison;

use Rubicon\Collection\Collection;
use Rubicon\Collection\CollectionInterface;
use Rubicon\Collection\Exception\RuntimeException;

class Comparator implements ComparatorInterface
{
    /**
     * @param CollectionInterface $from
     * @param CollectionInterface $to
     *
     * @return Collection
     */
    private function getMissing(CollectionInterface $from, CollectionInterface $to)
    {
        $removed = [];
        foreach ($from as $name => $element) {
            if (! $to->has($name)) {
                $removed[$name] = $element;
            }
        }
        return new Collection($removed);
    }

    /**
     * @param CollectionInterface $from
     * @param CollectionInterface $to
     *
     * @return Collection
     */
    private function getDiffs(CollectionInterface $from, CollectionInterface $to)
    {
        $modified = [];
        foreach ($from as $name => $element) {
            if ($to->has($name) && $to->get($name) !== $element) {
                $modified[$name] = new Diff($element, $to->get($name));
            }
        }
        return new Collection($modified);
    }

    /**
     * @param CollectionInterface $from
     * @param CollectionInterface $to
     *
     * @return Collection
     */
    private function getNew(CollectionInterface $from, CollectionInterface $to)
    {
        $added = [];
        foreach ($to as $name => $element) {
            if (! $from->has($name)) {
                $added[$name] = $element;
            }
        }
        return new Collection($added);
    }

    /**
     * Return a collection for all operations
     *
     * @param CollectionInterface $from
     * @param CollectionInterface $to
     *
     * @return ComparisonResult
     * @throws RuntimeException
     */
    public function compare(CollectionInterface $from, CollectionInterface $to)
    {
        if ($from === $to) {
            throw new RuntimeException('Compared collections point to the same object');
        }

        return new ComparisonResult(
            $this->getMissing($from, $to),
            $this->getDiffs($from, $to),
            $this->getNew($from, $to)
        );
    }
}