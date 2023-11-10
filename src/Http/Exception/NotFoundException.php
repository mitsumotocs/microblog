<?php

declare(strict_types=1);

namespace Project\Http\Exception;

use Project\Http\Response;

class NotFoundException extends HttpException
{
    protected const CODE = Response::STATUS_NOT_FOUND;
}
