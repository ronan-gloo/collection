<?php

namespace Rubicon\Collection;

require dirname(__DIR__) . '/vendor/autoload.php';

echo (new Collection([1, 2, 3]))
    ->map(function($item) {
        return $item * 2;
    })
    ->reduce(function($carry, $item) {
        return $item + $carry;
    });

echo PHP_EOL;