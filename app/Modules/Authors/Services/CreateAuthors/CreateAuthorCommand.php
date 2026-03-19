<?php

declare(strict_types=1);

namespace App\Modules\Authors\Services\CreateAuthors;

readonly class CreateAuthorCommand
{
    public function __construct(
        public string $name,
    ) {
    }
}
