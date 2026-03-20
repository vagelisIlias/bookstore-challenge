<?php

declare(strict_types=1);

namespace App\Modules\Books\Commands;

use App\Modules\Books\Database\Book;
use App\Modules\Books\Database\BookRepository;

readonly class BorrowBook
{
    public function __construct(
        public string $uuid,
        public string $borrowerName
    ) {}

    public function handle(BookRepository $bookRepository): Book
    {
        $book = $bookRepository->requireByUuid($this->uuid);

        $book->borrow($this->borrowerName);

        $bookRepository->save($book);

        return $book;
    }
}
