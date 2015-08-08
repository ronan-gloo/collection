<?php

namespace Rubicon\Collection;

use Rubicon\Collection\Exception\RuntimeException;

class CollectionCompare
{
    /**
     * @var CollectionInterface
     */
    private $original;
    /**
     * @var CollectionInterface
     */
    private $modified;

    /**
     * @param CollectionInterface $original
     * @param CollectionInterface $modified
     *
     * @throws RuntimeException
     */
    public function __construct(CollectionInterface $original, CollectionInterface $modified)
    {
        if ($original === $modified) {
            throw new RuntimeException('Compared collections point to the same object');
        }
        $this->original = $original;
        $this->modified = $modified;
    }

    /**
     * Return an associative array of elements that are present in original collection,
     * but removed from the modified one.
     *
     * @return Collection
     */
    public function getRemoved()
    {
        $removed = [];
        foreach ($this->original as $name => $element) {
            if (! $this->modified->has($name)) {
                $removed[$name] = $element;
            }
        }
        return new Collection($removed);
    }

    /**
     * Return an associative array of elements that are present in both collection,
     * but modified from the modified one.
     *
     * @return Collection   A collection of Diff objects
     */
    public function getModified()
    {
        $modified = [];
        foreach ($this->original as $name => $element) {
            if ($this->modified->has($name) && $this->modified->get($name) !== $element) {
                $modified[$name] = new Diff($element, $this->modified->get($name));
            }
        }
        return new Collection($modified);
    }

    /**
     * Return an associative array of elements that are present in modified collection,
     * but not in the original one.
     *
     * @return Collection
     */
    public function getAdded()
    {
        $added = [];
        foreach ($this->modified as $name => $element) {
            if (! $this->original->has($name)) {
                $added[$name] = $element;
            }
        }
        return new Collection($added);
    }

    /**
     * Return all operations
     *
     * @return Collection|Collection[]
     */
    public function getOperations()
    {
        return new Collection([
            'removed'  => $this->getRemoved(),
            'added'    => $this->getAdded(),
            'modified' => $this->getModified(),
        ]);
    }
}