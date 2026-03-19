<?php

declare(strict_types=1);

namespace App\Modules\Authors\Services\ListAuthors;

use App\Modules\Authors\Database\AuthorRepository;
use App\Modules\Authors\Services\ListAuthors\ListAuthorsQuery;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

final class ListAuthorsHandler
{
    public function __construct(private AuthorRepository $authorRepository)
    {
    }

    public function handle(ListAuthorsQuery $listAuthorsQuery): LengthAwarePaginator
    {
        return $this->authorRepository->findAllAuthors($listAuthorsQuery->perPage);
    }
}
