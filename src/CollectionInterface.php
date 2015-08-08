<?php

namespace Rubicon\Collection;

interface CollectionInterface extends Comparison\ComparableInterface, \IteratorAggregate, \Countable
{
    const FILTER_KEY = 0x01;
    const FILTER_VAL = 0x02;

    /**
     * @param mixed $key
     *
     * @return mixed
     */
    public function get($key);

    /**
     * @param mixed $key
     *
     * @return boolean
     */
    public function has($key);

    /**
     * @return static
     */
    public function keys();

    /**
     * @param mixed     $element
     * @param bool|true $strict
     *
     * @return bool
     */
    public function contains($element, $strict = true);

    /**
     * @param mixed $element
     * @param bool  $strict
     *
     * @return mixed
     */
    public function indexOf($element, $strict = true);

    /**
     * @param mixed $element
     * @param bool  $strict
     *
     * @return static
     */
    public function indexesOf($element, $strict = true);

    /**
     * @param callable $callable
     *
     * @return static
     */
    public function map(callable $callable);

    /**
     * @param callable $callable
     *
     * @return static
     */
    public function reduce(callable $callable);

    /**
     * Grab the first element of the collection
     *
     * @return mixed
     */
    public function first();

    /**
     * Grab the last element of the collection
     *
     * @return mixed
     */
    public function last();

    /**
     * @param     $startOrLength
     * @param int $length
     *
     * @return static
     */
    public function take($startOrLength, $length = null);

    /**
     * @param callable|null $callback
     * @param int           $flag
     *
     * @return static
     */
    public function filter(callable $callback = null, $flag = self::FILTER_VAL);

    /**
     * Return a new collection where items does not match true callback return value
     *
     * @param callable $callback
     * @param int      $flag
     *
     * @return mixed
     */
    public function reject(callable $callback, $flag = self::FILTER_VAL);

    /**
     * Filter elements by removing duplicate entries
     *
     * @param callable|int $callbackOrFlag
     *
     * @return static
     */
    public function distinct($callbackOrFlag = SORT_STRING);

    /**
     * Return the internal array representation of data
     *
     * @return array
     */
    public function toArray();
}