<?php

declare(strict_types=1);

namespace App\Modules\Authors\Services\CreateAuthors;

use App\Modules\Authors\Database\Author;

interface CreateAuthor
{
    public function handle(CreateAuthorCommand $command): Author;
}
