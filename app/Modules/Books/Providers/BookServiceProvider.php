<?php

declare(strict_types=1);

namespace App\Modules\Books\Providers;

use App\Modules\Books\Commands\BorrowBookCommand;
use App\Modules\Books\Commands\BorrowBookCommandHandler;
use App\Modules\Books\Commands\CreateBookCommand;
use App\Modules\Books\Commands\CreateBookCommandHandler;
use App\Modules\Books\Commands\ReturnBookCommand;
use App\Modules\Books\Commands\ReturnBookCommandHandler;
use App\Modules\Books\Contracts\BorrowBook;
use App\Modules\Books\Contracts\CreateBook;
use App\Modules\Books\Contracts\ReturnBook;
use App\Modules\Books\Database\BookRepository;
use App\Modules\Books\Database\EloquentBookRepository;
use App\Modules\Books\Database\Query\EloquentQueryRepository;
use App\Modules\Books\Database\Query\QueryRepository;
use App\Modules\Commands\AppCommandBus;
use App\Modules\Commands\CommandBus;
use Illuminate\Bus\Dispatcher;
use Illuminate\Support\ServiceProvider;

final class BookServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(CommandBus::class, AppCommandBus::class);
        $this->app->bind(BorrowBook::class, BorrowBookCommandHandler::class);
        $this->app->bind(ReturnBook::class, ReturnBookCommandHandler::class);
        $this->app->bind(BookRepository::class, EloquentBookRepository::class);
        $this->app->bind(CreateBook::class, CreateBookCommandHandler::class);
        $this->app->bind(QueryRepository::class, EloquentQueryRepository::class);
    }

    public function boot(): void
    {
        $dispatcher = $this->app->make(Dispatcher::class);

        $dispatcher->map([
            BorrowBookCommand::class => BorrowBookCommandHandler::class,
            ReturnBookCommand::class => ReturnBookCommandHandler::class,
            CreateBookCommand::class => CreateBookCommandHandler::class,
        ]);
    }
}
