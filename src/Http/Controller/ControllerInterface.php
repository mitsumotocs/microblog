<?php

declare(strict_types=1);

namespace Project\Http\Controller;

use Project\Http\Response;

interface ControllerInterface
{
    public function redirect(string $url, int $status = Response::STATUS_FOUND): Response;
}
