<?php

declare(strict_types=1);

namespace App\Modules\Books\Database;

use App\Modules\Books\Database\Book;
use App\Modules\Library\Database\Repository;

interface BookRepository extends Repository
{
    public function findByIsbn(string $isbn): ?Book;
}
