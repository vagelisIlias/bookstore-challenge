<?php

declare(strict_types=1);

namespace App\Modules\Books\Commands;

use App\Modules\Authors\Database\AuthorRepository;
use App\Modules\Books\Database\Book;
use App\Modules\Books\Database\BookRepository;
use App\Modules\Books\Exceptions\BookAlreadyExistsException;

readonly class CreateBook
{
    public function __construct(
        public string $title,
        public string $isbn,
        public string $authorUuid,
    ) {}

    public function handle(BookRepository $bookRepository, AuthorRepository $authorRepository): Book
    {
        $existingBook = $bookRepository->findByIsbn($this->isbn);
        $author = $authorRepository->requireByUuid($this->authorUuid);

        if ($existingBook) {
            throw new BookAlreadyExistsException();
        }

        $book = Book::new($this->title, $this->isbn, $author->id);
        $bookRepository->save($book);

        return $book;
    }
}
