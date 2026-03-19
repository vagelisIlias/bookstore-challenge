<?php

declare(strict_types=1);

namespace App\Modules\Books\Services\UpdateBook;

readonly class UpdateBookDto
{
    public function __construct(
        public ?string $isbn = null,
        public ?bool $available = null,
        public ?string $borrowerName = null,
        public ?int $isActive = null,
    ) {
    }
}
