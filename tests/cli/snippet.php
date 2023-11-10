<?php

declare(strict_types=1);

require_once __DIR__ . '/../../vendor/autoload.php';

$array = [1, 2, 3];
$array = [];

array_shift($array);

var_dump($array);