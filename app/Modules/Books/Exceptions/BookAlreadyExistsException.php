<?php

declare(strict_types=1);

namespace App\Modules\Books\Exceptions;

use Exception;
use Throwable;

class BookAlreadyExistsException extends Exception
{
    public function __construct(?Throwable $previous = null)
    {
        parent::__construct(
            message: "Book already exists",
            code: 409,
            previous: $previous
        );
    }
}
