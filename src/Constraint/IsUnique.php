<?php

namespace Rubicon\Collection\Constraint;

use Rubicon\Collection\CollectionInterface;

class IsUnique
{
    const VALIDATE_KEY     = 0;
    const VALIDATE_ELEMENT = 1;

    /**
     * @var int
     */
    private $mode;

    /**
     * @param int  $mode
     * @param bool $strict
     */
    public function __construct($mode = self::VALIDATE_ELEMENT, $strict = true)
    {
        $this->mode = (int) $mode;
        $this->strict = (bool) $strict;
    }

    /**
     * @param mixed               $item
     * @param CollectionInterface $collection
     *
     * @return bool
     */
    public function __invoke($item, CollectionInterface $collection)
    {
        if (self::VALIDATE_KEY === $this->mode) {
            return ! $collection->has($item);
        }

        return ! $collection->contains($item, $this->strict);
    }
}