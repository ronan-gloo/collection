<?php

namespace Rubicon\Collection;

use Rubicon\Collection\Constraint\IsInstanceOf;

require dirname(__DIR__) . '/vendor/autoload.php';

$validation = new IsInstanceOf([\ArrayObject::class, \stdClass::class]);
$collection = new MutableCollection([], $validation);

$collection->add(new \ArrayObject);
$collection->add(new \stdClass);

print_r($collection->toImmutable());