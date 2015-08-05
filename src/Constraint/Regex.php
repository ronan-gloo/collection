<?php

namespace Rubicon\Collection\Constraint;

class Regex
{
    /**
     * @var array
     */
    private static $posixChars = [
        ':alnum:', ':print:', ':graph:', ':cntrl:',
        ':space:', ':blank:', ':punct:', ':xdigit:',
        ':digit:', ':alpha:', ':lower:', ':upper:'
    ];

    /**
     * @var int
     */
    private $offset;

    /**
     * @var string
     */
    private $pattern;

    /**
     * @param string $pattern
     * @param int    $offset
     * @param string $delimiter
     */
    public function __construct($pattern, $offset = 0, $delimiter = '`')
    {
        if (in_array($pattern, static::$posixChars)) {
            $pattern = '[[' . $pattern . ']]';
        }

        $this->pattern = $delimiter . $pattern . $delimiter;
        $this->offset  = $offset;
    }

    /**
     * @param mixed $value
     *
     * @return bool
     */
    public function __invoke($value)
    {
        if (null === $value || is_scalar($value)) {
            return (bool) preg_match($this->pattern, $value, $matches, null, $this->offset);
        }

        return false;
    }
}