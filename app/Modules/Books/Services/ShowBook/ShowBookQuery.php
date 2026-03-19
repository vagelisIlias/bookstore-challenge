<?php

declare(strict_types=1);

namespace App\Modules\Books\Services\ShowBook;

readonly class ShowBookQuery
{
    public function __construct(public string $uuid) {}
}
