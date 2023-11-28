<?php

declare(strict_types=1);

use Sqids\Sqids;

require_once __DIR__ . '/../../vendor/autoload.php';

$sqids = new Sqids(Sqids::DEFAULT_ALPHABET, 8);

$numbers = [];
$numbers[] = 0;
$numbers[] = 1;
$numbers[] = 192168001001;
$numbers[] = 255255255255;

foreach ($numbers as $number) {
    $id = $sqids->encode([$number]);
    echo sprintf('%d => %s (%d)', $number, $id, strlen($id)), PHP_EOL;
}
