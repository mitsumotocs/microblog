<?php

declare(strict_types=1);

use Project\Http\Controller\TestController;
use Project\Http\Request;

require_once __DIR__ . '/../../vendor/autoload.php';

$url = '/items/1234';
$re = '/\A\/items\/(\w+)\z/';
$re = '/(\w+\z/';

set_error_handler(function () {}, E_WARNING);

$match = preg_match($re, '');

restore_error_handler();
var_dump($match);

//$result = preg_match($re, $url, $matches);
//var_dump($result, $matches);