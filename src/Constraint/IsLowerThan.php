<?php

namespace Rubicon\Collection\Constraint;

class IsGreaterThan
{
    /**
     * @var bool
     */
    private $inclusive;

    /**
     * @var mixed
     */
    private $value;

    /**
     * @param mixed      $value
     * @param bool|false $inclusive
     */
    public function __construct($value, $inclusive = false)
    {
        $this->value     = $value;
        $this->inclusive = (bool) $inclusive;
    }

    /**
     * @param mixed $value
     *
     * @return bool
     */
    public function __invoke($value)
    {
        return $this->inclusive
            ? $value >= $this->value
            : $value >  $this->value
        ;
    }
}