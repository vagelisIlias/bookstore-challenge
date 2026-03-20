<?php

declare(strict_types=1);

namespace Tests\Feature\Modules\Books\Commands;

use App\Modules\Books\Commands\ReturnBook;
use App\Modules\Books\Database\Book;
use App\Modules\Books\Database\BookRepository;
use App\Modules\Books\Exceptions\BookNotFoundException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

final class ReturnBookTest extends TestCase
{
    use RefreshDatabase;

    public function test_returns_book_successfully(): void
    {
        // Arrange
        $repository = $this->createMock(BookRepository::class);
        $book = $this->createMock(Book::class);

        $repository->method('requireByUuid')
            ->with('book-uuid-123')
            ->willReturn($book);

        $book->expects($this->once())
            ->method('return');

        $repository->expects($this->once())
            ->method('save')
            ->with($book);

        $command = new ReturnBook('book-uuid-123');

        // Act
        $result = $command->handle($repository);

        // Assert
        $this->assertSame($book, $result);
    }

    public function test_throws_exception_when_book_not_found(): void
    {
        // Arrange
        $repository = $this->createMock(BookRepository::class);

        $repository->method('requireByUuid')
            ->with('book-uuid-123')
            ->willThrowException(new BookNotFoundException());

        $this->expectException(BookNotFoundException::class);

        // Act
        $command = new ReturnBook('book-uuid-123');
        $command->handle($repository);
    }
}
