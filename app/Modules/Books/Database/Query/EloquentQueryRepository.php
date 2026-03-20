<?php

declare(strict_types=1);

namespace App\Modules\Books\Database\Query;

use App\Modules\Authors\Database\Author;

final class EloquentQueryRepository implements QueryRepository
{
    public function findAuthorByUuid(string $uuid): ?Author
    {
        return Author::where('uuid', $uuid)->first();
    }
}
