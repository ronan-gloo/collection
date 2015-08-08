<?php

namespace Rubicon\Collection\Comparison;

use Rubicon\Collection\CollectionInterface;

class ComparisonResult
{
    /**
     * @var CollectionInterface
     */
    private $missingElements;
    /**
     * @var CollectionInterface
     */
    private $diffElements;
    /**
     * @var CollectionInterface
     */
    private $newElements;

    /**
     * @param CollectionInterface $missingElements
     * @param CollectionInterface $diffElements
     * @param CollectionInterface $newElements
     */
    public function __construct(
        CollectionInterface $missingElements,
        CollectionInterface $diffElements,
        CollectionInterface $newElements
    ) {
        $this->missingElements = $missingElements;
        $this->diffElements    = $diffElements;
        $this->newElements     = $newElements;
    }

    /**
     * @param string $name
     *
     * @return CollectionInterface
     */
    public function missing($name = null)
    {
        return isset($name) ? $this->missingElements->get($name) : $this->missingElements;
    }

    /**
     * @param string $name
     *
     * @return CollectionInterface|DiffInterface[]|DiffInterface
     */
    public function diff($name = null)
    {
        return isset($name) ? $this->diffElements->get($name) : $this->diffElements;
    }

    /**
     * @param string $name
     *
     * @return CollectionInterface
     */
    public function additional($name = null)
    {
        return isset($name) ? $this->newElements->get($name) : $this->newElements;
    }
}