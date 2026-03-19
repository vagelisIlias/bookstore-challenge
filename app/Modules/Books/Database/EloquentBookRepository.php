<?php

declare(strict_types=1);

namespace App\Modules\Books\Database;

use App\Modules\Books\Database\Book;
use App\Modules\Books\Database\BookRepository;
use App\Modules\Books\Services\UpdateBook\UpdateBookDto;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

final class EloquentBookRepository implements BookRepository
{
    public function findAllBooks(array $filters, int $perPage = 10): LengthAwarePaginator
    {
        $query = Book::query()->with('author');

        if (isset($filters['available'])) {
            $query->where('available', $filters['available']);
        }

        return $query->paginate($perPage);
    }

    public function findByUuid(string $uuid): ?Book
    {
        return Book::with('author')->where('uuid', $uuid)->first();
    }

    public function updateBook(Book $book, UpdateBookDto $updateBookDto): Book
    {
        $book->update([
            'isbn' => $updateBookDto->isbn ?? $book->isbn,
            'available' => $updateBookDto->available ?? $book->available,
            'borrower_name' => $updateBookDto->borrowerName ?? $book->borrower_name,
            'is_active' => $updateBookDto->isActive ?? $book->is_active,
        ]);

        return $book;
    }
}
