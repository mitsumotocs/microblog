<?php

declare(strict_types=1);

use Project\Http\Application;
use Project\Http\Request;

require_once __DIR__ . '/../../vendor/autoload.php';

//var_dump(new Application());
$request = Request::createFromScratch(
    'GET',
    '/foo/bar',
    [],
    [
        'name' => 'Alice',
    ],
);
//var_dump($request);

$app = new Application();
$response = $app->run($request);
$response->headers['X-Foo'] = 'FOO';
$response->headers['X-Uniqid'] = uniqid();
//var_dump($response);
echo $response;

//$app();
