<?php

declare(strict_types=1);

namespace App\Modules\Authors\Commands;

use App\Modules\Authors\Database\Author;
use App\Modules\Authors\Database\AuthorRepository;
use App\Modules\Authors\Exceptions\AuthorAlreadyExistsException;

readonly class CreateAuthor
{
    public function __construct(
        private string $name,
    ) {
    }

    public function handle(AuthorRepository $authorRepository): Author
    {
        $existingAuthor = $authorRepository->findByName($this->name);

        if ($existingAuthor) {
            throw new AuthorAlreadyExistsException();
        }

        $author = Author::new($this->name);
        $authorRepository->save($author);

        return $author;
    }
}
