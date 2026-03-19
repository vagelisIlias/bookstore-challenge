<?php

declare(strict_types=1);

namespace App\Modules\Books\Commands;

use App\Modules\Books\Commands\BorrowBookCommand;
use App\Modules\Books\Contracts\BorrowBook;
use App\Modules\Books\Database\Book;
use App\Modules\Books\Database\BookRepository;
use App\Modules\Books\Exceptions\BookIsBorrowedException;
use App\Modules\Books\Exceptions\BookNotFoundException;
use App\Modules\Books\Services\UpdateBook\UpdateBookDto;

final class BorrowBookCommandHandler implements BorrowBook
{
    public function __construct(private BookRepository $bookRepository)
    {}

    public function handle(BorrowBookCommand $command): Book
    {
        $book = $this->bookRepository->findByUuid($command->uuid);

        if (!$book) {
            throw new BookNotFoundException();
        }

        if (!$book->isAvailable()) {
            throw new BookIsBorrowedException();
        }

        return $this->bookRepository->updateBook($book, new UpdateBookDto(
            available: false,
            borrowerName: $command->borrowerName
        ));
    }
}
