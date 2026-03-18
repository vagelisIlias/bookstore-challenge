<?php

declare(strict_types=1);

namespace App\Modules\Authors\Database;

use App\Modules\Authors\Services\CreateAuthors\CreateAuthorDto;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface AuthorRepository
{
    public function findAllAuthors(int $perPage): LengthAwarePaginator;
    public function findByName(string $name): ?Author;
    public function storeAuthor(CreateAuthorDto $createAuthorDto): Author;
}
