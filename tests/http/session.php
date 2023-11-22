<?php

declare(strict_types=1);

use Project\Http\Session;

require_once __DIR__ . '/../../vendor/autoload.php';

$session = new Session([
    'name' => 'MY_SESSION',
    'sid_bits_per_character' => 5,
]);

if (!isset($session->data['uid'])) {
    $session->data['uid'] = uniqid();
}

$session->data['count'] = isset($session->data['count']) ? $session->data['count'] + 1 : 0;

if ($session->data['count'] % 5 === 0) {
    $session->renew();
}

var_dump($session->id, $session->data['uid'], $session->data['count']);
