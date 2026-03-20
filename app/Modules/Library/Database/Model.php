<?php

namespace App\Modules\Library\Database;

use Illuminate\Database\Eloquent\Model as EloquentModel;
use Illuminate\Database\Eloquent\ModelNotFoundException;

abstract class Model extends EloquentModel
{
    abstract public static function newModelNotFoundException(): ModelNotFoundException;
}
