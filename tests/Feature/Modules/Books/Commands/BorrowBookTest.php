<?php

namespace Tests\Feature\Modules\Books\Commands;
use App\Modules\Books\Commands\BorrowBook;
use App\Modules\Books\Database\Book;
use App\Modules\Books\Database\BookRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

final class BorrowBookTest extends TestCase
{
    use RefreshDatabase;

    public function test_borrows_book_successfully(): void
    {
        // Arrange
        $repository = $this->createMock(BookRepository::class);
        $book = $this->createMock(Book::class);

        $repository->method('requireByUuid')
            ->with('book-uuid-123')
            ->willReturn($book);

        $book->expects($this->once())
            ->method('borrow')
            ->with('John Doe');

        $repository->expects($this->once())
            ->method('save')
            ->with($book);

        $command = new BorrowBook('book-uuid-123', 'John Doe');

        // Act
        $result = $command->handle($repository);

        // Assert
        $this->assertSame($book, $result);
    }
}
