<?php

declare(strict_types=1);

namespace App\Modules\Authors\Exceptions;

use Exception;
use Throwable;

final class AuthorAlreadyExistsException extends Exception
{
    public function __construct(?Throwable $previous = null)
    {
        parent::__construct(
            message: "This Author already exists",
            code: 409,
            previous: $previous
        );
    }
}
