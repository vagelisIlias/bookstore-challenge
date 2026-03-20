<?php

declare(strict_types=1);

namespace App\Modules\Books\Database;

use App\Modules\Books\Database\Book;
use App\Modules\Books\Database\BookRepository;
use App\Modules\Library\Database\EloquentRepository;

final class EloquentBookRepository extends EloquentRepository implements BookRepository
{
    public function __construct(Book $model)
    {
        parent::__construct($model);
    }

    public function findByIsbn(string $isbn): ?Book
    {
        return Book::where('isbn', $isbn)->first();
    }
}
