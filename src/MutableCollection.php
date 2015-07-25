<?php

namespace Rubicon\Collection;

class MutableCollection extends Collection implements MutableCollectionInterface
{
    /**
     * {@inheritdoc}
     */
    public function set($key, $element)
    {
        $this->validateKey($key);
        $this->validateElement($element, $key);
        $this->elements[$key] = $element;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function add($element)
    {
        $key = $this->count();
        $this->validateKey($key);
        $this->validateElement($element, $key);
        $this->elements[] = $element;

        return $this;
    }

    /**
     * Check if the value is accepted by the collection
     *
     * @param mixed $element
     *
     * @return bool
     */
    public function accept($element)
    {
        if ($this->elementValidator) {
            return (bool) call_user_func($this->elementValidator, $element, $this);
        }

        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function remove($element, $strict = true)
    {
        while(false !== ($index = array_search($element, $this->elements, $strict))) {
            unset($this->elements[$index]);
        }

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function delete($key)
    {
        if (array_key_exists($key, $this->elements)) {
            unset($this->elements[$key]);
        }

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function clear()
    {
        $this->elements = [];

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function exchangeWith($collectionOrArray)
    {
        $this->elements = [];
        foreach ($collectionOrArray as $key => $value) {
            $this->set($key, $value);
        }

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function replace($originalElement, $newElement = null, $strict = true)
    {
        foreach($this->indexesOf($originalElement, $strict) as $index) {
            $this->set($index, $newElement);
        }

        return $this;
    }

    /**
     * @return Collection
     */
    public function toImmutable()
    {
        return new Collection($this->elements);
    }
}