<?php

declare(strict_types=1);

use Ramsey\Uuid\Uuid;

require_once __DIR__ . '/../../vendor/autoload.php';

//$uuid = Uuid::uuid4();

/*
printf(
    "UUID: %s\nVersion: %d\n",
    $uuid->toString(),
    $uuid->getFields()->getVersion()
);
*/

for ($i = 0; $i < 3; $i++) {
    $uuid = Uuid::uuid4();
    //var_dump($uuid);
    $uuidAsString = $uuid->toString();
    echo sprintf('%s (%d)', $uuidAsString, strlen($uuidAsString)) , PHP_EOL;
}
