<?php

declare(strict_types=1);

namespace App\Modules\Authors\Services\CreateAuthors;

use App\Modules\Authors\Database\Author;
use App\Modules\Authors\Database\AuthorRepository;
use App\Modules\Authors\Exceptions\AuthorAlreadyExistsException;
use App\Modules\Authors\Services\CreateAuthors\CreateAuthor;
use App\Modules\Authors\Services\CreateAuthors\CreateAuthorCommand;

final class CreateAuthorCommandHandler implements CreateAuthor
{
    public function __construct(
        private AuthorRepository $authorRepository
    ) {
    }

    public function handle(CreateAuthorCommand $createAuthorCommand): Author
    {
        $existingAuthor = $this->authorRepository->findByName($createAuthorCommand->name);

        if ($existingAuthor) {
            throw new AuthorAlreadyExistsException();
        }

        return $this->authorRepository->storeAuthor($createAuthorCommand);
    }
}
