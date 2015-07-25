<?php

namespace Rubicon\Collection\Constraint;

class IsTypeOf
{
    /**
     * @param string|array $types
     */
    public function __construct($types)
    {
        if (! is_array($types)) {
            $types = func_get_args();
        }
        $this->types = $types;
    }

    /**
     * @param mixed $value
     *
     * @return bool
     */
    public function __invoke($value)
    {
        return in_array(gettype($value), $this->types);
    }
}