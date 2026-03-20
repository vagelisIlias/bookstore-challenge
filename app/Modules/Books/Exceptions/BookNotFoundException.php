<?php

declare(strict_types=1);

namespace App\Modules\Books\Exceptions;

use Illuminate\Database\Eloquent\ModelNotFoundException;

final class BookNotFoundException extends ModelNotFoundException
{
    public function __construct()
    {
        parent::__construct('Book not found');
    }
}
