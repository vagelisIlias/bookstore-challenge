<?php

declare(strict_types=1);

namespace App\Modules\Books\Commands;

readonly class BorrowBookCommand
{
    public function __construct(
        public string $uuid,
        public string $borrowerName
    ) {}
}
