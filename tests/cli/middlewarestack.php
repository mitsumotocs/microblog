<?php

declare(strict_types=1);

use Project\Http\Middleware\MiddlewareInterface;
use Project\Http\Middleware\MiddlewareStack;

require_once __DIR__ . '/../../vendor/autoload.php';

class M1 implements MiddlewareInterface
{

}

class M2 implements MiddlewareInterface
{

}

class M3 implements MiddlewareInterface
{

}

$stack = new MiddlewareStack([
    new M1,
    new M2,
]);
// $stack->push(new M1);
// $stack->push(new M2);
$stack->push(new M3);
//var_dump($stack);
var_dump($stack->first());
var_dump($stack->next());
var_dump($stack->next());
//var_dump($stack->next());
