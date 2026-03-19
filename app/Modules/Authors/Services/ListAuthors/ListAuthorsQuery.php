<?php

declare(strict_types=1);

namespace App\Modules\Authors\Services\ListAuthors;

readonly class ListAuthorsQuery
{
    public function __construct(public int $perPage = 15)
    {
    }
}
