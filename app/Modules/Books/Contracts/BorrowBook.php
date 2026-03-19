<?php

declare(strict_types=1);

namespace App\Modules\Books\Contracts;

use App\Modules\Books\Commands\BorrowBookCommand;
use App\Modules\Books\Database\Book;

interface BorrowBook
{
    public function handle(BorrowBookCommand $command): Book;
}
