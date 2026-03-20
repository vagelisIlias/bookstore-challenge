<?php

declare(strict_types=1);

namespace App\Modules\Books\Database\Query;

use App\Modules\Authors\Database\Author;

interface QueryRepository
{
    public function findAuthorByUuid(string $uuid): ?Author;
}
