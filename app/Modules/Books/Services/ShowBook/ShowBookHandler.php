<?php

declare(strict_types=1);

namespace App\Modules\Books\Services\ShowBook;

use App\Modules\Books\Database\Book;
use App\Modules\Books\Database\BookRepository;
use App\Modules\Books\Exceptions\BookNotFoundException;

final class ShowBookHandler
{
    public function __construct(private BookRepository $bookRepository)
    {
    }

    public function handle(ShowBookQuery $query): Book
    {
        $book = $this->bookRepository->findByUuid($query->uuid);

        if (!$book) {
            throw new BookNotFoundException();
        }

        return $book;
    }
}
