<?php

declare(strict_types=1);

namespace App\Modules\Authors\Commands;

use App\Modules\Authors\Commands\CommandBus;
use Illuminate\Bus\Dispatcher;

final class AuthorCommandBus implements CommandBus
{
    public function __construct(private Dispatcher $dispatcher)
    {
    }

    public function dispatch(object $command): mixed
    {
        return $this->dispatcher->dispatch($command);
    }

    public function map(array $map): void
    {
        $this->dispatcher->map($map);
    }
}
