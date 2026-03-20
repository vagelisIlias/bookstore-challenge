<?php

declare(strict_types=1);

namespace App\Modules\Authors\Exceptions;

use Illuminate\Database\Eloquent\ModelNotFoundException;

final class AuthorNotFoundException extends ModelNotFoundException
{
    public function __construct()
    {
        parent::__construct("Author not found");
    }
}
