<?php

declare(strict_types=1);

use Project\Di\Container;
use Project\Http\Application;
use Project\Http\Controller\TestController;
use Project\Http\Middleware\ErrorHandlingMiddleware;
use Project\Http\Middleware\MiddlewareInterface;
use Project\Http\Middleware\MiddlewareStack;
use Project\Http\Request;
use Project\Http\Response;

require_once __DIR__ . '/../../vendor/autoload.php';

class ExampleMiddleware implements MiddlewareInterface
{
    public function __invoke(Request $request, MiddlewareStack $stack): Response
    {
        $response = $stack->next()($request, $stack);
        $response->headers[$this::class] = 'passed';
        return $response;
    }
}

class AnotherExampleMiddleware implements MiddlewareInterface
{
    public function __invoke(Request $request, MiddlewareStack $stack): Response
    {
        if (strcasecmp($request->headers['x-country'] ?? '', 'JP') !== 0) {
            return new Response(Response::STATUS_FORBIDDEN, [], 'Unavailable in your country');
        }

        $response = $stack->next()($request, $stack);
        $response->headers[$this::class] = 'passed';
        return $response;
    }
}

$c = new Container([]);

/** @var Application $app */
$app = $c[Application::class];

$app
    ->addMiddleware($c[ExampleMiddleware::class])
    ->addMiddleware($c[AnotherExampleMiddleware::class])
    ->addMiddleware($c[ErrorHandlingMiddleware::class])
    ->route('GET', '/\A\/\z/', $c[TestController::class])
    ->route('GET', '/\A\/items\/(\w+)\z/', $c[TestController::class], 'item');

//var_dump($app);

$request = Request::createFromScratch(
    'GET',
    '/items/1234',
    [
        'x-country' => 'jp',
    ],
    [
        'name' => 'Alice',
    ],
);

$response = $app->handleRequest($request);
echo $response, PHP_EOL;
