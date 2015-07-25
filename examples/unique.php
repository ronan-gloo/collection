<?php

namespace Rubicon\Collection;

require dirname(__DIR__) . '/vendor/autoload.php';

$obj1 = new \stdClass();
$obj1->id = 1;
$obj1->data = '1';

$obj2 = new \stdClass();
$obj2->id = 1;
$obj2->data = '2';

$obj3 = new \stdClass();
$obj3->id = 2;
$obj3->data = '3';

$collection = new Collection([$obj1, $obj2, $obj3]);

print_r($collection->unique(function($obj) {
    return $obj->id;
}));

print_r($collection->unique());