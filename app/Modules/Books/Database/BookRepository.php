<?php

declare(strict_types=1);

namespace App\Modules\Books\Database;

use App\Modules\Books\Database\Book;
use App\Modules\Books\Services\UpdateBook\UpdateBookDto;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface BookRepository
{
    public function findAllBooks(array $filters, int $perPage = 10): LengthAwarePaginator;
    public function findByUuid(string $uuid): ?Book;
    public function updateBook(Book $book, UpdateBookDto $updateBookDto): Book;
}
