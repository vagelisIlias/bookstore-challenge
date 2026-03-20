<?php

declare(strict_types=1);

namespace App\Modules\Books\Exceptions;

use Exception;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Throwable;

class BookIsBorrowedException extends HttpException
{
    public function __construct(?Throwable $previous = null)
    {
        parent::__construct(
            409,
            "Book is already borrowed",
            $previous,
        );
    }
}
