<?php

declare(strict_types=1);

use Project\Http\Application;

require_once __DIR__ . '/../../vendor/autoload.php';

$app = new Application();
$app();