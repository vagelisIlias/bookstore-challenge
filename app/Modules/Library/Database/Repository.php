<?php

declare(strict_types=1);

namespace App\Modules\Library\Database;

use App\Modules\Library\Database\Model;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface Repository
{
    public function findAll(?QueryFilter $filter = null): LengthAwarePaginator;
    public function requireByUuid(string $uuid): Model;
    public function save(Model $model): void;
}
