<?php

declare(strict_types=1);

namespace App\Modules\Authors\Providers;

use App\Modules\Authors\Database\AuthorRepository;
use App\Modules\Authors\Database\EloquentAuthorRepository;
use Illuminate\Support\ServiceProvider;

final class AuthorServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        parent::register();

        $this->app->singleton(AuthorRepository::class, EloquentAuthorRepository::class);
    }
}
