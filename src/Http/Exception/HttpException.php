<?php

declare(strict_types=1);

namespace Project\Http\Exception;

use Exception;
use Throwable;

class HttpException extends Exception
{
    protected const CODE = 0;

    public function __construct(string $message = '', int $code = 0, ?Throwable $previous = null)
    {
        parent::__construct($message, $code ?? static::CODE, $previous);
    }
}
