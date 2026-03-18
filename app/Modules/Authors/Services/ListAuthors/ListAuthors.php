<?php

declare(strict_types=1);

namespace App\Modules\Authors\Services\ListAuthors;

use App\Modules\Authors\Services\ListAuthors\ListAuthorsDto;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface ListAuthors
{
    public function handle(ListAuthorsDto $listAuthorsDto): LengthAwarePaginator;
}
