<?php

declare(strict_types=1);

use Project\Di\Container;

require_once __DIR__ . '/../../vendor/autoload.php';

class SomeLibrary
{
    public function __invoke()
    {
        return 'some library';
    }
}

class SomeClassThatRequiresSomeLibrary
{
    public function __construct(
        private SomeLibrary $someLibrary,
    ) {
    }

    public function __invoke()
    {
        return 'some class uses ' . $this->someLibrary->__invoke();
    }
}

$definitions = [
    'null' => null,
    'string' => 'some string value',
    'array' => [1, 2, 3],
    'factory' => function () {
        return 'value that a factory created';
    },
];

$c = new Container($definitions);
//var_dump($container);
var_dump($c->get('null'));
var_dump($c->get('string'));
var_dump($c->get('string'));
var_dump($c->get('factory'));
var_dump($c->get('factory'));
//var_dump($c->get('ClassThatDoesNotExist'));
var_dump($c->get(SomeLibrary::class));
var_dump($c->get(SomeLibrary::class));
//var_dump($c->get(SomeClassThatRequiresSomeLibrary::class));
var_dump($c[SomeClassThatRequiresSomeLibrary::class]);
var_dump(isset($c['ClassThatDoesNotExist']));
