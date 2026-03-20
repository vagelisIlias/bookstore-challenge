<?php

declare(strict_types=1);

namespace App\Modules\Books\Commands;

readonly class CreateBookCommand
{
    public function __construct(
        public string $title,
        public string $isbn,
        public string $authorUuid,
    ) {}
}
