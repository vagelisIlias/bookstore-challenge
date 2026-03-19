<?php

declare(strict_types=1);

namespace App\Modules\Books\Services\ListBooks;

use App\Modules\Books\Database\BookRepository;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

final class ListBooksHandler
{
    public function __construct(private BookRepository $bookRepository) {}

    public function handle(ListBooksQuery $query): LengthAwarePaginator
    {
        $filters = [];
        if ($query->available !== null) {
            $filters['available'] = $query->available;
        }

        return $this->bookRepository->findAllBooks($filters, $query->perPage);
    }
}
