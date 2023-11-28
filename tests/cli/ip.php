<?php

declare(strict_types=1);

require_once __DIR__ . '/../../vendor/autoload.php';

$ips[] = '0.0.0.0';
$ips[] = '255.255.255.255';
$ips[] = '203.168.116.105';
$ips[] = '203.168.116.106';
$ips[] = '192.168.0.1';
$ips[] = '0000:0000:0000:0000:0000:0000:0000:0000';
$ips[] = '2a00:8640:0001:0000:0224:36ff:feef:1d89';
$ips[] = 'ffff:ffff:ffff:ffff:ffff:ffff:ffff:ffff';

foreach ($ips as $ip) {
    $bin = inet_pton($ip);
    //$str = bin2hex($bin);
    //$str = (string) hexdec($str);
    //$str = sha1(bin2hex($bin));
    //$str = base_convert($str, 16, 36);
    $str = hash('murmur3a', $bin); // looks OK
    echo sprintf('%s => %s (%d)', $ip, $str, strlen($str)), PHP_EOL;
}

//var_dump(hash_algos());