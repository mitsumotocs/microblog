<?php

declare(strict_types=1);

if (php_sapi_name() === 'cli-server') {
    if (file_exists($_SERVER['SCRIPT_FILENAME'])) {
        return false;
    }
    require_once __DIR__ . '/index.php';
}
