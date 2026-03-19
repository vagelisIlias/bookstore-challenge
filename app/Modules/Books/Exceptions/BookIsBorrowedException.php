<?php

declare(strict_types=1);

namespace App\Modules\Books\Exceptions;

use Exception;
use Throwable;

final class BookIsBorrowedException extends Exception
{
    public function __construct(?Throwable $previous = null)
    {
        parent::__construct(
            message: "Book is already borrowed",
            code: 409,
            previous: $previous
        );
    }
}
