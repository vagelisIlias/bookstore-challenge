<?php

declare(strict_types=1);

namespace App\Modules\Authors\Providers;

use Illuminate\Bus\Dispatcher;
use Illuminate\Support\ServiceProvider;
use App\Modules\Authors\Commands\CommandBus;
use App\Modules\Authors\Commands\AuthorCommandBus;
use App\Modules\Authors\Database\AuthorRepository;
use App\Modules\Authors\Database\EloquentAuthorRepository;
use App\Modules\Authors\Services\CreateAuthors\CreateAuthorCommand;
use App\Modules\Authors\Services\CreateAuthors\CreateAuthorCommandHandler;
use App\Modules\Authors\Services\ListAuthors\ListAuthorsHandler;
use App\Modules\Authors\Services\ListAuthors\ListAuthorsQuery;

final class AuthorServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        parent::register();

        $this->app->bind(AuthorRepository::class, EloquentAuthorRepository::class);
        $this->app->bind(ListAuthorsQuery::class, ListAuthorsHandler::class);
        $this->app->bind(CommandBus::class, AuthorCommandBus::class);
    }

    public function boot(): void
    {
        $dispatcher = $this->app->make(Dispatcher::class);

        $dispatcher->map([
            CreateAuthorCommand::class => CreateAuthorCommandHandler::class,
        ]);
    }
}
