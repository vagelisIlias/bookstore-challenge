<?php

declare(strict_types=1);

namespace App\Modules\Authors\Services\CreateAuthors;

use App\Modules\Authors\Database\Author;
use App\Modules\Authors\Services\CreateAuthors\CreateAuthorDto;

interface CreateAuthor
{
    public function handle(CreateAuthorDto $createAuthorDto): Author;
}
