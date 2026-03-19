<?php

declare(strict_types=1);

namespace App\Modules\Authors\Database;

use App\Modules\Authors\Database\Author;
use App\Modules\Authors\Database\AuthorRepository;
use App\Modules\Authors\Services\CreateAuthors\CreateAuthorCommand;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

final class EloquentAuthorRepository implements AuthorRepository
{
    public function findAllAuthors(int $perPage): LengthAwarePaginator
    {
        return Author::paginate($perPage);
    }

    public function findByName(string $name): ?Author
    {
        return Author::where('name', $name)->first();
    }

    public function storeAuthor(CreateAuthorCommand $createAuthorCommand): Author
    {
        return Author::create([
            'name' => $createAuthorCommand->name,
        ]);
    }
}
