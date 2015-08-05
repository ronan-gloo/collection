<?php

namespace Rubicon\Collection;

use Rubicon\Collection\Constraint\CompositeConstraint;
use Rubicon\Collection\Constraint\IsGreaterThan;
use Rubicon\Collection\Constraint\IsTypeOf;
use Rubicon\Collection\Constraint\Regex;

require dirname(__DIR__) . '/vendor/autoload.php';

$constraint = new CompositeConstraint([
    new IsTypeOf('integer'),
    new IsGreaterThan(2),
], CompositeConstraint::CONSTRAINT_AND);

try {
    new MutableCollection([1, 2, 3], $constraint);
} catch (\Exception $exception) {
    echo $exception->getMessage() . PHP_EOL;
}

$collection = new MutableCollection([], new Regex('^api/.*$'));
$collection->add('api/result');