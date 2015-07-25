<?php

namespace Rubicon\Collection;

require dirname(__DIR__) . '/vendor/autoload.php';

try {
    new MutableCollection(['test', 'test'], new Constraint\IsUnique);
}
catch (Exception\ValidationException $exception) {
    echo $exception->getMessage() . PHP_EOL;
}
