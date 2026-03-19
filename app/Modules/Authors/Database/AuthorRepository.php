<?php

declare(strict_types=1);

namespace App\Modules\Authors\Database;

use App\Modules\Authors\Commands\CreateAuthorCommand;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface AuthorRepository
{
    public function findAllAuthors(int $perPage): LengthAwarePaginator;
    public function findByName(string $name): ?Author;
    public function storeAuthor(CreateAuthorCommand $createAuthorCommand): Author;
}
