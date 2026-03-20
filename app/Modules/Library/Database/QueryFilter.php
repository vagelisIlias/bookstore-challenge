<?php

namespace App\Modules\Library\Database;

use Illuminate\Database\Eloquent\Builder;

interface QueryFilter
{
    public function apply(Builder $query): Builder;
}
