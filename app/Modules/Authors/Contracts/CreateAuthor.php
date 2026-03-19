<?php

declare(strict_types=1);

namespace App\Modules\Authors\Contracts;

use App\Modules\Authors\Commands\CreateAuthorCommand;
use App\Modules\Authors\Database\Author;

interface CreateAuthor
{
    public function handle(CreateAuthorCommand $command): Author;
}
