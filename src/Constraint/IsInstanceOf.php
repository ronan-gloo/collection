<?php

namespace Rubicon\Collection\Constraint;

class IsInstanceOf
{
    /**
     * @var array
     */
    private $classNames;

    /**
     * @param string|string[] $classNames
     */
    public function __construct($classNames)
    {
        $this->classNames = (array) $classNames;
    }

    /**
     * @param $value
     *
     * @return bool
     */
    public function __invoke($value)
    {
        foreach ($this->classNames as $name) {
            if ($value instanceof $name) {
                return true;
            }
        }
        return false;
    }
}