<?php

namespace Rubicon\Collection;

use Rubicon\Collection\Constraint\IsEqualTo;

require dirname(__DIR__) . '/vendor/autoload.php';

$collection = new Collection([1, 2, 3]);
$sliced = $collection->reject(new IsEqualTo(1));

print_r($sliced);