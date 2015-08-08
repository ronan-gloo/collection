<?php

namespace Rubicon\Collection;

use Rubicon\Collection\Exception\RuntimeException;
use Rubicon\Collection\Pipeline\PipelineProviderTrait;
use Rubicon\Collection\Validation\ValidationProviderTrait;

class Collection implements CollectionInterface, \ArrayAccess
{
    use PipelineProviderTrait;
    use ValidationProviderTrait;

    /**
     * @var array
     */
    protected $elements = [];

    /**
     * Collection constructor.
     *
     * @param array    $elements
     * @param callable $elementValidator
     * @param callable $keyValidator
     */
    public function __construct(array $elements = [], callable $elementValidator = null, callable $keyValidator = null)
    {
        $this->elementValidator = $elementValidator;
        $this->keyValidator     = $keyValidator;

        if ($this->elementValidator || $this->keyValidator) {
            foreach ($elements as $key => $element) {
                $this->validateElement($element, $key);
                $this->validateKey($key);
                $this->elements[$key] = $element;
            }
        } else {
            $this->elements = $elements;
        }
    }

    /**
     * {@inheritdoc}
     */
    public function map(callable $callable)
    {
        $elements = array_map($callable, $this->elements);

        return new self($elements);
    }

    /**
     * {@inheritdoc}
     */
    public function reduce(callable $callable)
    {
        return array_reduce($this->elements, $callable);
    }

    /**
     * {@inheritdoc}
     */
    public function get($reference)
    {
        if (isset($this->elements[$reference])) {
            return $this->elements[$reference];
        }
    }

    /**
     * {@inheritdoc}
     */
    public function keys()
    {
        return new self(array_keys($this->elements));
    }

    /**
     * @param mixed $key
     *
     * @return boolean
     */
    public function has($key)
    {
        return isset($this->elements[$key]) || array_key_exists($key, $this->elements);
    }

    /**
     * @param mixed     $element
     * @param bool|true $strict
     *
     * @return bool
     */
    public function contains($element, $strict = true)
    {
        return in_array($element, $this->elements, $strict);
    }

    /**
     * {@inheritdoc}
     */
    public function indexOf($element, $strict = true)
    {
        $index = array_search($element, $this->elements, $strict);

        return $index === false ? -1 : $index;
    }

    /**
     * {@inheritdoc}
     */
    public function indexesOf($element, $strict = true)
    {
        $elements = $this->elements;
        $indexes  = [];
        while(false !== ($index = array_search($element, $elements, $strict))) {
            unset($elements[$index]);
            $indexes[] = $index;
        }

        return new self($indexes);
    }

    /**
     * {@inheritdoc}
     */
    public function first()
    {
        $elements = $this->elements;
        return reset($elements);
    }

    /**
     * {@inheritdoc}
     */
    public function last()
    {
        $elements = $this->elements;
        return end($elements);
    }

    /**
     * {@inheritdoc}
     */
    public function take($startOrLength, $length = null)
    {
        if (null === $length) {
            $length = $startOrLength;
            $startOrLength = 0;
        }

        return new self(array_slice($this->elements, $startOrLength, $length));
    }

    /**
     * {@inheritdoc}
     */
    public function filter(callable $callback = null, $flag = self::FILTER_VAL)
    {
        if (null === $callback) {
            return new self(array_filter($this->elements));
        }
        $elements = [];
        foreach ($this->elements as $key => $element) {
            if (call_user_func($callback, (self::FILTER_KEY == $flag) ? $key : $element, $this)) {
                $elements[$key] = $element;
            }
        }

        return new self($elements);
    }

    /**
     * {@inheritdoc}
     */
    public function reject(callable $callback, $flag = self::FILTER_VAL)
    {
        $elements = [];
        foreach ($this->elements as $key => $element) {
            if (! call_user_func($callback, (self::FILTER_KEY == $flag) ? $key : $element, $this)) {
                $elements[$key] = $element;
            }
        }

        return new self($elements);
    }

    /**
     * {@inheritdoc}
     */
    public function distinct($callbackOrFlag = SORT_REGULAR)
    {
        if (is_numeric($callbackOrFlag)) {
            return new static(array_unique($this->elements, $callbackOrFlag));
        }
        if (! is_callable($callbackOrFlag)) {
            throw new \InvalidArgumentException('Expecting a numeric or callable');
        }

        $elements = [];
        $indexes  = [];
        foreach ($this->elements as $key => $element) {
            $index = call_user_func($callbackOrFlag, $element, $this);
            if (! in_array($index, $indexes, true)) {
                $elements[$key] = $element;
                $indexes[] = $index;
            }
        }

        return new self($elements);
    }

    /**
     * {@inheritdoc}
     */
    public function toArray()
    {
        return $this->elements;
    }

    /**
     * {@inheritdoc}
     */
    public function getIterator()
    {
        foreach ($this->elements as $element) {
            yield $element;
        }
    }

    /**
     * {@inheritdoc}
     */
    public function count()
    {
        return count($this->elements);
    }

    /**
     * {@inheritdoc}
     */
    public function offsetExists($offset)
    {
        return $this->has($offset);
    }

    /**
     * {@inheritdoc}
     */
    public function offsetGet($offset)
    {
        return $this->get($offset);
    }

    /**
     * {@inheritdoc}
     */
    public function offsetSet($offset, $value)
    {
        throw new RuntimeException(get_class($this) . ' is read-only');
    }

    /**
     * {@inheritdoc}
     */
    public function offsetUnset($offset)
    {
        throw new RuntimeException(get_class($this) . ' is read-only');
    }
}