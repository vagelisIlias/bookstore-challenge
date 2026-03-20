<?php

declare(strict_types=1);

namespace App\Modules\Books\Contracts;

use App\Modules\Books\Commands\CreateBookCommand;
use App\Modules\Books\Database\Book;

interface CreateBook
{
    public function handle(CreateBookCommand $command): Book;
}
