<?php

namespace Rubicon\Collection\Validation;

use Rubicon\Collection\Exception\ValidationException;

trait ValidationProviderTrait
{
    /**
     * @var callable
     */
    protected $keyValidator;

    /**
     * @var callable
     */
    protected $elementValidator;

    /**
     * @param mixed $key
     *
     * @throws ValidationException
     */
    protected function validateKey($key)
    {
        if ($this->keyValidator && ! call_user_func($this->keyValidator, $key, $this)) {
            throw new ValidationException(sprintf(
                '"%s", key "%s" is not valid',
                $this->serializeValidator($this->keyValidator),
                $key
            ));
        }
    }

    /**
     * @param mixed $element
     *
     * @param       $key
     *
     * @throws ValidationException
     */
    protected function validateElement($element, $key)
    {
        if ($this->elementValidator && ! call_user_func($this->elementValidator, $element, $this)) {
            throw new ValidationException(sprintf(
                '"%s", element "%s" is not valid at index "%s"',
                $this->serializeValidator($this->elementValidator),
                $this->serializeElement($element),
                $key
            ));
        }
    }

    /**
     * @param callable $validator
     *
     * @return callable|string
     */
    private function serializeValidator(callable $validator)
    {
        if (is_string($validator)) {
            return $validator;
        }
        if (is_object($validator)) {
            return get_class($validator);
        }
        if (is_array($validator)) {
            return get_class($validator[0]) . '::' . $validator[1];
        }
    }

    /**
     * @param $element
     *
     * @return string
     */
    private function serializeElement($element)
    {
        if (is_string($element)) {
            return $element;
        }
        if (is_object($element)) {
            return get_class($element);
        }

        return gettype($element);
    }
}