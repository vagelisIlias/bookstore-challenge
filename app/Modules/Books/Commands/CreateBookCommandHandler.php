<?php

declare(strict_types=1);

namespace App\Modules\Books\Commands;

use App\Modules\Books\Commands\CreateBookCommand;
use App\Modules\Books\Contracts\CreateBook;
use App\Modules\Books\Database\Book;
use App\Modules\Books\Database\BookRepository;
use App\Modules\Books\Database\Query\QueryRepository;
use App\Modules\Books\Exceptions\AuthorNotFoundException;
use App\Modules\Books\Exceptions\BookAlreadyExistsException;

final class CreateBookCommandHandler implements CreateBook
{
    public function __construct(
        private BookRepository $bookRepository,
        private QueryRepository $queryRepository
    ) {
    }

    public function handle(CreateBookCommand $command): Book
    {
        $existingBook = $this->bookRepository->findByIsbn($command->isbn);
        $author = $this->queryRepository->findAuthorByUuid($command->authorUuid);

        if ($existingBook) {
            throw new BookAlreadyExistsException();
        }

        if (!$author) {
            throw new AuthorNotFoundException();
        }

        return $this->bookRepository->storeBook(
            $command->title,
            $command->isbn,
            $author->id
        );
    }
}
