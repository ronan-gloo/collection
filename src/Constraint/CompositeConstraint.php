<?php

namespace Rubicon\Collection\Constraint;

use Rubicon\Collection\CollectionInterface;

class CompositeConstraint
{
    const CONSTRAINT_AND = 1;
    const CONSTRAINT_OR  = 2;

    /**
     * @var callable[]
     */
    private $constraints;

    /**
     * CompositeConstraint constructor.
     *
     * @param \callable[] $constraints
     * @param int         $mode
     */
    public function __construct(array $constraints = [], $mode = self::CONSTRAINT_AND)
    {
        $this->mode = $mode;
        foreach ($constraints as $constraint) {
            $this->add($constraint);
        }
    }

    /**
     * @param mixed               $value
     * @param CollectionInterface $collection
     *
     * @return bool
     */
    public function __invoke($value, CollectionInterface $collection)
    {
        $response = 0;
        foreach ($this->constraints as $constraint) {
            $result = call_user_func($constraint, $value, $collection);
            if (false === $result && self::CONSTRAINT_AND === $this->mode) {
                return false;
            }
            $response |= (int) $result;
        }

        return (bool) ($response & 1);
    }

    /**
     * @return \callable[]
     */
    public function getConstraints()
    {
        return $this->constraints;
    }

    /**
     * @param callable $callable
     */
    public function add(callable $callable)
    {
        $this->constraints[] = $callable;
    }

    /**
     * @return int
     */
    public function getMode()
    {
        return $this->mode;
    }
}