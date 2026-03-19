<?php

declare(strict_types=1);

namespace Tests\Feature\Modules\Books\Commands;
use App\Modules\Authors\Database\Author;
use App\Modules\Books\Commands\BorrowBookCommand;
use App\Modules\Books\Contracts\BorrowBook;
use App\Modules\Books\Database\Book;
use App\Modules\Books\Database\BookRepository;
use App\Modules\Books\Exceptions\BookIsBorrowedException;
use App\Modules\Books\Exceptions\BookNotFoundException;
use App\Modules\Books\Services\UpdateBook\UpdateBookDto;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

final class BorrowBookCommandHandlerTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_can_borrow_an_available_book(): void
    {
        // Arrange
        $uuid = '1234-test-uuid';
        $author = Author::factory()->create();
        $book = Book::factory()->create([
            'uuid' => '1234-test-uuid',
            'available' => true,
            'borrower_name' => 'Nikolas',
            'author_id' => $author->id,
        ]);

        $mockRepo = $this->createMock(BookRepository::class);
        $mockRepo->expects($this->once())
            ->method('findByUuid')
            ->with($uuid)
            ->willReturn($book);

        $mockRepo->expects($this->once())
            ->method('updateBook')
            ->with($book, $this->isInstanceOf(UpdateBookDto::class))
            ->willReturn($book);

        $this->app->instance(BookRepository::class, $mockRepo);
        $handler = $this->app->make(BorrowBook::class);
        $command = new BorrowBookCommand(uuid: $book->uuid, borrowerName: $book->borrower_name);

        $handler = $this->app->make(BorrowBook::class);

        // Act
        $result = $handler->handle($command);

        // Assert
        $this->assertEquals('Nikolas', $result->borrower_name);
    }

    public function test_it_throws_exception_if_book_not_found(): void
    {
        // Arrange
        $this->expectException(BookNotFoundException::class);
        $this->expectExceptionMessage('Book not found');

        $command = new BorrowBookCommand(
            uuid: 'non-existent-uuid',
            borrowerName: 'Nikolas'
        );

        // Act
        $handler = $this->app->make(BorrowBook::class);
        $handler->handle($command);
    }

    public function test_it_throws_exception_if_book_already_borrowed(): void
    {
        // Arrange
        $author = Author::factory()->create();
        $book = Book::factory()->create([
            'uuid' => '1234-test-uuid',
            'available' => false,
            'borrower_name' => 'Someone Else',
            'author_id' => $author->id,
        ]);

        $this->expectException(BookIsBorrowedException::class);
        $this->expectExceptionMessage('Book is already borrowed');

        $command = new BorrowBookCommand(
            uuid: $book->uuid,
            borrowerName: 'Nikolas'
        );

        // Act
        $handler = $this->app->make(BorrowBook::class);
        $handler->handle($command);
    }
}
