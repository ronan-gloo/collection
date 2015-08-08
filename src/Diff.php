<?php

namespace Rubicon\Collection;

class Diff
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
     * @return mixed
     */
    public function getOriginal()
    {
        return $this->original;
    }

    /**
     * @return mixed
     */
    public function getModified()
    {
        return $this->modified;
    }
}