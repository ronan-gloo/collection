<?php

namespace Rubicon\Collection;

interface MutableCollectionInterface
{
    /**
     * @param mixed $key
     * @param mixed $element
     *
     * @return $this
     */
    public function set($key, $element);

    /**
     * @param mixed $element
     *
     * @return $this
     */
    public function add($element);

    /**
     * Check if the value is accepted by the collection
     *
     * @param mixed $element
     *
     * @return bool
     */
    public function accept($element);

    /**
     * @param mixed $element
     * @param bool  $strict
     *
     * @return $this
     */
    public function remove($element, $strict = true);

    /**
     * @param mixed $key
     *
     * @return $this
     */
    public function delete($key);

    /**
     * @param \Traversable|array $traversableOrArray
     *
     * @return $this
     */
    public function exchangeWith($traversableOrArray);

    /**
     * @param mixed $elementOrCallback
     * @param mixed $newElement
     *
     * @param bool  $strict
     *
     * @return $this
     */
    public function replace($elementOrCallback, $newElement = null, $strict = true);

    /**
     * @return $this
     */
    public function clear();
}