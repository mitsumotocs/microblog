<?php

declare(strict_types=1);

use Project\Http\Application;
use Project\Http\Request;

require_once __DIR__ . '/../../vendor/autoload.php';

$app = new Application();

$request = Request::createFromScratch(
    'GET',
    '/items/1234',
    [],
    [
        'name' => 'Alice',
    ],
);
//var_dump($request);

$response = $app->handleRequest($request);
echo $response, PHP_EOL;
