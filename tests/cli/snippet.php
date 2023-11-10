<?php

declare(strict_types=1);

use Project\Http\Controller\TestController;
use Project\Http\Request;

require_once __DIR__ . '/../../vendor/autoload.php';

$route = [
    'controller' => new TestController(),
    'action' => 'item',
];

$request = Request::createFromScratch('GET', '/');
//$response = $route['controller']->$route['action']($request, []);
$response = call_user_func([$route['controller'], $route['action']], $request, []);
var_dump($response);

//var_dump($route);
//echo $route['action'], PHP_EOL;