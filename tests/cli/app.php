<?php

declare(strict_types=1);

use Project\Http\Application;
use Project\Http\Controller\TestController;
use Project\Http\Middleware\RoutingMiddleware;
use Project\Http\Request;

require_once __DIR__ . '/../../vendor/autoload.php';

$request = Request::createFromScratch(
    'GET',
    '/items/1234',
    [],
    [
        'name' => 'Alice',
    ],
);
//var_dump($request);

$controller = new TestController();

$app = new Application();

// TODO: pushing middleware is untested!
$app->middlewareStack->push(new RoutingMiddleware());

$app
->route('GET', '/\A\/\z/', $controller)
->route('GET', '/\A\/items\/(\w+)\z/', $controller, 'item');
var_dump($app);

$response = $app->handleRequest($request);
echo $response, PHP_EOL;
