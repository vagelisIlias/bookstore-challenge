<?php

declare(strict_types=1);

namespace App\Modules\Books\Contracts;

use App\Modules\Books\Commands\ReturnBookCommand;
use App\Modules\Books\Database\Book;

interface ReturnBook
{
    public function handle(ReturnBookCommand $command): Book;
}
