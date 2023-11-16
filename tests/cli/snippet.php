<?php

declare(strict_types=1);

use Project\Http\Controller\TestController;
use Project\Http\Request;

require_once __DIR__ . '/../../vendor/autoload.php';

class ExampleArrayAccess implements ArrayAccess
{
    public array $container = [
        "one"   => 1,
        "two"   => 2,
        "three" => 3,
    ];

    public function offsetSet($offset, $value): void {
        if (is_null($offset)) {
            $this->container[] = $value;
        } else {
            $this->container[$offset] = $value;
        }
    }

    public function offsetExists($offset): bool {
        return isset($this->container[$offset]);
    }

    public function offsetUnset($offset): void {
        unset($this->container[$offset]);
    }

    public function offsetGet($offset): mixed {
        return isset($this->container[$offset]) ? $this->container[$offset] : null;
    }
}

$array = new ExampleArrayAccess();
$array[1] = 'one';
//$array['foo']['bar'] = 'BAR';
$array['a'] = [
    'b' => ['c', 'd', 'e'],
];
var_dump($array);
var_dump($array['one']);