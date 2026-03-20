<?php

declare(strict_types=1);

namespace App\Modules\Books\Commands;

use App\Modules\Books\Database\Book;
use App\Modules\Books\Database\BookRepository;
use App\Modules\Books\Exceptions\BookNotFoundException;

readonly class ReturnBook
{
    public function __construct(public string $uuid) {}

    public function handle(BookRepository $bookRepository): Book
    {
        $book = $bookRepository->requireByUuid($this->uuid);

        if (!$book) {
           throw new BookNotFoundException();
        }

        $book->return();
        $bookRepository->save($book);

        return $book;
    }
}
