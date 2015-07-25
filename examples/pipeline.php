<?php

namespace Rubicon\Collection;

require dirname(__DIR__) . '/vendor/autoload.php';

$pipeline = (new Collection([1, 2, 3]))
    ->pipe(
        function(CollectionInterface $collection) {
            return $collection
                ->map(function($item){
                    return $item + 1;
                })
                ->map(function($item){
                    return $item / 2;
                });
        },
        function(CollectionInterface $collection) {
            return $collection
                ->reject(function($item){
                    return $item === 2;
                })
                ->reduce(function($carry, $item){
                    return $carry + $item;
                });
        }
    );

echo $pipeline->execute() . PHP_EOL;
