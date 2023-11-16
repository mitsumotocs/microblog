<?php

declare(strict_types=1);

use Project\Http\Session;

require_once __DIR__ . '/../../vendor/autoload.php';

$session = new Session([]);

if (!isset($session['uid'])) {
    $session['uid'] = uniqid();
}

$session['count'] = isset($session['count']) ? $session['count'] + 1 : 0;

if ($session['count'] % 5 === 0) {
    //$sessionRenewed = $session->renew();
    $session->renew();
}

//var_dump($session);
var_dump($session->id, $session['uid'], $session['count']);