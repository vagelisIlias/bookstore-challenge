<?php

declare(strict_types=1);

namespace App\Modules\Authors\Providers;

use App\Modules\Authors\Commands\CreateAuthorCommand;
use App\Modules\Authors\Commands\CreateAuthorCommandHandler;
use App\Modules\Authors\Database\AuthorRepository;
use App\Modules\Authors\Database\EloquentAuthorRepository;
use App\Modules\Authors\Services\ListAuthors\ListAuthorsHandler;
use App\Modules\Authors\Services\ListAuthors\ListAuthorsQuery;
use App\Modules\Commands\AppCommandBus;
use App\Modules\Commands\CommandBus;
use Illuminate\Bus\Dispatcher;
use Illuminate\Support\ServiceProvider;

final class AuthorServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        parent::register();

        $this->app->bind(AuthorRepository::class, EloquentAuthorRepository::class);
        $this->app->bind(ListAuthorsQuery::class, ListAuthorsHandler::class);
        $this->app->bind(CommandBus::class, AppCommandBus::class);
    }

    public function boot(): void
    {
        $dispatcher = $this->app->make(Dispatcher::class);

        $dispatcher->map([
            CreateAuthorCommand::class => CreateAuthorCommandHandler::class,
        ]);
    }
}
