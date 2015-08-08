<?php

namespace Rubicon\Collection\Comparison;

class Diff implements DiffInterface
{
    /**
     * @var mixed
     */
    private $original;

    /**
     * @var mixed
     */
    private $modified;

    /**
     * @param mixed $original
     * @param mixed $modified
     */
    public function __construct($original, $modified)
    {
        $this->original = $original;
        $this->modified = $modified;
    }

    /**
     * {@inheritdoc}
     */
    public function getOriginal()
    {
        return $this->original;
    }

    /**
     * {@inheritdoc}
     */
    public function getModified()
    {
        return $this->modified;
    }
}