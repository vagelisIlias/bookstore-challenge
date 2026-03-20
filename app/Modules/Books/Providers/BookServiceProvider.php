<?php

declare(strict_types=1);

namespace App\Modules\Books\Providers;

use App\Modules\Books\Database\BookRepository;
use App\Modules\Books\Database\EloquentBookRepository;
use Illuminate\Support\ServiceProvider;

final class BookServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton(BookRepository::class, EloquentBookRepository::class);
    }
}
