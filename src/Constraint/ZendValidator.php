<?php

namespace Rubicon\Collection\Constraint;

use Rubicon\Collection\CollectionInterface;
use Zend\Validator\ValidatorInterface;

class ZendValidator
{
    /**
     * @var ValidatorInterface
     */
    private $validator;

    /**
     * @param \Zend\Validator\ValidatorInterface|null $validator
     */
    public function __construct(ValidatorInterface $validator)
    {
        $this->validator = $validator;
    }

    /**
     * @param mixed               $value
     * @param CollectionInterface $collection
     *
     * @return bool
     */
    public function __invoke($value, CollectionInterface $collection = null)
    {
        return $this->validator->isValid($value, $collection);
    }
}