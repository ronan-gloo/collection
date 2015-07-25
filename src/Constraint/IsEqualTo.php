<?php

namespace Rubicon\Collection\Constraint;

class IsEqualTo
{
    /**
     * @var bool
     */
    private $strict;

    /**
     * @var mixed
     */
    private $value;

    /**
     * @param mixed $value
     * @param bool  $strict
     */
    public function __construct($value, $strict = true)
    {
        $this->value  = $value;
        $this->strict = (bool) $strict;
    }

    /**
     * @param mixed $value
     *
     * @return bool
     */
    public function __invoke($value)
    {
        if (true === $this->strict) {
            return $this->value === $value;
        }

        return $this->value == $value;
    }
}