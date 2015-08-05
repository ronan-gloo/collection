<?php

namespace Rubicon\Collection;

use Rubicon\Collection\Constraint\ZendValidator;
use Zend\Validator\EmailAddress;

require dirname(__DIR__) . '/vendor/autoload.php';

$constraint = new ZendValidator(new EmailAddress());
$collection = new Collection([
    'test@test.com',
    'hello world',
    'i-am-ok@you.com'
]);

$result = $collection->filter($constraint);
print_r($result->get());