<?php

declare(strict_types=1);

namespace App\Modules\Books\Exceptions;

use Symfony\Component\HttpKernel\Exception\HttpException;
use Throwable;

class BookIsNotBorrowedException extends HttpException
{
    public function __construct(?Throwable $previous = null)
    {
        parent::__construct(
            409,
            "Book is not borrowed",
            $previous
        );
    }
}
