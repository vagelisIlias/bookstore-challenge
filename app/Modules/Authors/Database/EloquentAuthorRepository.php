<?php

declare(strict_types=1);

namespace App\Modules\Authors\Database;

use App\Modules\Authors\Database\Author;
use App\Modules\Authors\Database\AuthorRepository;
use App\Modules\Library\Database\EloquentRepository;

final class EloquentAuthorRepository extends EloquentRepository implements AuthorRepository
{
    public function __construct(Author $model)
    {
        parent::__construct($model);
    }

    public function findByName(string $name): ?Author
    {
        return Author::where('name', $name)->first();
    }
}
