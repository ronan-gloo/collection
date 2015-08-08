<?php

namespace Rubicon\Collection\Comparison;

use Rubicon\Collection\Collection;
use Rubicon\Collection\CollectionInterface;
use Rubicon\Collection\Exception\RuntimeException;

class CollectionCompare implements CollectionCompareInterface
{
    const OPERATION_MODIFIED = 'modified';
    const OPERATION_REMOVED  = 'removed';
    const OPERATION_ADDED    = 'added';

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
     * {@inheritdoc}
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
     * {@inheritdoc}
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
     * {@inheritdoc}
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
     * Return a collection for all operations
     *
     * @return CollectionInterface|CollectionInterface[]
     */
    public function getOperations()
    {
        return new Collection([
            self::OPERATION_REMOVED  => $this->getRemoved(),
            self::OPERATION_ADDED    => $this->getAdded(),
            self::OPERATION_MODIFIED => $this->getModified(),
        ]);
    }
}