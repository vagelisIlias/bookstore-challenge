<?php

declare(strict_types=1);

namespace App\Modules\Authors\Commands;

interface CommandBus
{
    public function dispatch(object $command): mixed;
}
