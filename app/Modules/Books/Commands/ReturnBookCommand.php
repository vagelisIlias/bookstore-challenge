<?php

declare(strict_types=1);

namespace App\Modules\Books\Commands;

readonly class ReturnBookCommand
{
    public function __construct(public string $uuid) {}
}
