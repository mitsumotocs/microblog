<?php

declare(strict_types=1);

use Project\Http\Controller\TestController;
use Project\Http\Request;

require_once __DIR__ . '/../../vendor/autoload.php';

$factory = function () {
    return 'making something';
};
$factory = null;

var_dump(is_callable($factory));