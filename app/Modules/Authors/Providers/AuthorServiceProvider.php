<?php

declare(strict_types=1);

namespace App\Modules\Authors\Providers;

use Illuminate\Support\ServiceProvider;
use App\Modules\Authors\Database\AuthorRepository;
use App\Modules\Authors\Database\EloquentAuthorRepository;
use App\Modules\Authors\Services\CreateAuthors\CreateAuthor;
use App\Modules\Authors\Services\CreateAuthors\CreateAuthorHandler;
use App\Modules\Authors\Services\ListAuthors\ListAuthors;
use App\Modules\Authors\Services\ListAuthors\ListAuthorsHandler;

final class AuthorServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        parent::register();

        $this->app->bind(AuthorRepository::class, EloquentAuthorRepository::class);
        $this->app->bind(CreateAuthor::class, CreateAuthorHandler::class);
        $this->app->bind(ListAuthors::class, ListAuthorsHandler::class);
    }
}
