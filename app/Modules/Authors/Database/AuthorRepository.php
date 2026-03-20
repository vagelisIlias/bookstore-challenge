<?php

declare(strict_types=1);

namespace App\Modules\Authors\Database;

use App\Modules\Library\Database\Repository;

interface AuthorRepository extends Repository
{
    public function findByName(string $name): ?Author;
}
