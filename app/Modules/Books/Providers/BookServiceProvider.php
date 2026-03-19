<?php

declare(strict_types=1);

namespace App\Modules\Books\Providers;

use App\Modules\Books\Commands\BorrowBookCommand;
use App\Modules\Books\Commands\BorrowBookCommandHandler;
use App\Modules\Books\Commands\ReturnBookCommand;
use App\Modules\Books\Commands\ReturnBookCommandHandler;
use App\Modules\Books\Database\BookRepository;
use App\Modules\Books\Database\EloquentBookRepository;
use App\Modules\Commands\AppCommandBus;
use App\Modules\Commands\CommandBus;
use Illuminate\Bus\Dispatcher;
use Illuminate\Support\ServiceProvider;

final class BookServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(CommandBus::class, AppCommandBus::class);
        $this->app->bind(BookRepository::class, EloquentBookRepository::class);
    }

    public function boot(): void
    {
        $dispatcher = $this->app->make(Dispatcher::class);

        $dispatcher->map([
            BorrowBookCommand::class => BorrowBookCommandHandler::class,
            ReturnBookCommand::class => ReturnBookCommandHandler::class,
        ]);
    }
}
