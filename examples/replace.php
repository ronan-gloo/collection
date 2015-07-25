<?php

namespace Rubicon\Collection;

require dirname(__DIR__) . '/vendor/autoload.php';

$objects = new MutableCollection();

$objects->add('1');
$objects->add(1);
$objects->replace(1, 2, false);

print_r($objects->get());