<?php

declare(strict_types=1);

namespace App\Modules\Books\Commands;

use App\Modules\Books\Contracts\ReturnBook;
use App\Modules\Books\Database\Book;
use App\Modules\Books\Database\BookRepository;
use App\Modules\Books\Exceptions\BookIsNotBorrowedException;
use App\Modules\Books\Exceptions\BookNotFoundException;
use App\Modules\Books\Services\UpdateBook\UpdateBookDto;

final class ReturnBookCommandHandler implements ReturnBook
{
    public function __construct(private BookRepository $bookRepository)
    {}

    public function handle(ReturnBookCommand $command): Book
    {
        $book = $this->bookRepository->findByUuid($command->uuid);

        if (!$book) {
           throw new BookNotFoundException();
        }

        if ($book->available) {
            throw new BookIsNotBorrowedException();
        }

        return $this->bookRepository->updateBook($book, new UpdateBookDto(
            available: true,
        ));
    }
}
