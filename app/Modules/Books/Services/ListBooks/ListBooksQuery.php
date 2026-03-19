<?php

declare(strict_types=1);

namespace App\Modules\Books\Services\ListBooks;

readonly class ListBooksQuery
{
    public function __construct(
        public int $perPage = 10,
        public ?bool $available = null
    ) {
    }
}
