<?php

declare(strict_types=1);

use Project\Http\Exception\HttpException;
use Project\Http\Exception\NotFoundException;

require_once __DIR__ . '/../../vendor/autoload.php';

$e1 = new HttpException('test');
$e2 = new NotFoundException('another test',  0, $e1);

//var_dump($e1);
//var_dump($e2);

//throw $e1;
echo $e1->__toString(), PHP_EOL;
