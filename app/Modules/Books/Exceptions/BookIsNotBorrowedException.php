<?php

declare(strict_types=1);

namespace App\Modules\Books\Exceptions;

use Exception;
use Throwable;

final class BookIsNotBorrowedException extends Exception
{
    public function __construct(?Throwable $previous = null)
    {
        parent::__construct(
            message: "Book is not borrowed",
            code: 400,
            previous: $previous
        );
    }
}
