<?php

declare(strict_types=1);

namespace App\Modules\Library\Database;

use App\Modules\Library\Database\Model;
use App\Modules\Library\Database\QueryFilter;
use App\Modules\Library\Database\Repository;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class EloquentRepository implements Repository
{
    public function __construct(protected Model $model)
    {
    }

    public function findAll(?QueryFilter $filter = null): LengthAwarePaginator
    {
        $query = $this->model->newQuery();
        if (!is_null($filter)) {
            $query = $filter->apply($query);
        }

        return $query->paginate();
    }

    public function requireByUuid(string $uuid): Model
    {
        try {
            return $this->model->newQuery()->where('uuid', $uuid)->firstOrFail();
        } catch (ModelNotFoundException) {
            throw $this->model::newModelNotFoundException();
        }
    }

    public function save(Model $model): void
    {
        $model->save();
    }
}
