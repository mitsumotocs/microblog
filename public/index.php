<?php

declare(strict_types=1);

use Project\Di\Container;
use Project\Http\Application;
use Project\Http\Controller\PostController;
use Project\Http\Controller\TestController;
use Project\Http\Middleware\ContentLengthMiddleware;
use Project\Http\Middleware\ErrorHandlingMiddleware;

require_once __DIR__ . '/../vendor/autoload.php';

$container = new Container([]);

$app = new Application();

$app
    ->addMiddleware($container[ContentLengthMiddleware::class])
    ->addMiddleware($container[ErrorHandlingMiddleware::class]);

$app
    ->route('GET', '/\A\/\z/', $container[TestController::class])
    ->route('GET', '/\A\/posts\z/', $container[PostController::class], 'index')
    ->route('POST', '/\A\/posts\/create\z/', $container[PostController::class], 'create');
//->route('GET', '/\A\/items\/(\w+)\z/', $container[TestController::class], 'item');

$app();
