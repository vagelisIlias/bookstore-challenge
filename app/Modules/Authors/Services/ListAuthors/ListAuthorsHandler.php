<?php

declare(strict_types=1);

namespace App\Modules\Authors\Services\ListAuthors;

use App\Modules\Authors\Database\AuthorRepository;
use App\Modules\Authors\Services\ListAuthors\ListAuthors;
use App\Modules\Authors\Services\ListAuthors\ListAuthorsDto;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

final class ListAuthorsHandler implements ListAuthors
{
    public function __construct(private AuthorRepository $authorRepository)
    {
    }

    public function handle(ListAuthorsDto $listAuthorsDto): LengthAwarePaginator
    {
        return $this->authorRepository->findAllAuthors($listAuthorsDto->perPage);
    }
}
