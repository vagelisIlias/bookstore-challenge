<?php

declare(strict_types=1);

namespace App\Modules\Books\Exceptions;

use Exception;
use Throwable;

final class AuthorNotFoundException extends Exception
{
    public function __construct(?Throwable $previous = null)
    {
        parent::__construct(
            message: "Author not found",
            code: 404,
            previous: $previous
        );
    }
}
