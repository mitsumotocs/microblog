<?php

declare(strict_types=1);

namespace Project\Test;

use Project\Http\Controller\ControllerInterface;
use Project\Http\Controller\ControllerTrait;
use Project\Http\Middleware\MiddlewareStack;
use Project\Http\Middleware\RoutingMiddleware;
use Project\Http\Request;
use Project\Http\Response;

require_once __DIR__ . '/../../vendor/autoload.php';

class ExampleController implements ControllerInterface
{
    use ControllerTrait;

    public function __invoke(Request $request): Response
    {
        $response = new Response();
        $response->body = $this::class;
        return $response;
    }
}

class AnotherExampleController extends ExampleController implements ControllerInterface
{
    public function item(Request $request, array $params): Response
    {
        $response = new Response();
        $response->body = 'item action with params: ' . implode(', ', $params) . ' in ' . $this::class;
        return $response;
    }
}

$request = Request::createFromScratch('GET', '/items/apple');

$stack = new MiddlewareStack();
$router = new RoutingMiddleware();
$router->route('GET', '/\A\/\z/', new ExampleController());
$router->route('GET', '/\A\/items\/(\w+)\z/', new AnotherExampleController(), 'item');

$response = $router($request, $stack);
var_dump($response);
