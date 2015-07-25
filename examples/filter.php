<?php

namespace Rubicon\Collection;

require dirname(__DIR__) . '/vendor/autoload.php';

$collection = new Collection([
    'string',
    123,
    new \stdClass()
]);

$callable = new Constraint\IsTypeOf('object');
print_r($collection->filter($callable));