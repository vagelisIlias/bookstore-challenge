<?php

declare(strict_types=1);

namespace Tests\Feature\Modules\Books\Commands;

use App\Modules\Authors\Database\Author;
use App\Modules\Books\Commands\ReturnBookCommand;
use App\Modules\Books\Contracts\ReturnBook;
use App\Modules\Books\Database\Book;
use App\Modules\Books\Database\BookRepository;
use App\Modules\Books\Exceptions\BookIsNotBorrowedException;
use App\Modules\Books\Exceptions\BookNotFoundException;
use App\Modules\Books\Services\UpdateBook\UpdateBookDto;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

final class ReturnBookCommandHandlerTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_can_return_a_borrowed_book(): void
    {
        // Arrange
        $uuid = '1234-test-uuid';
        $author = Author::factory()->create();
        $book = Book::factory()->create([
            'uuid' => '1234-test-uuid',
            'available' => false,
            'borrower_name' => null,
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
        $handler = $this->app->make(ReturnBook::class);
        $command = new ReturnBookCommand(uuid: $book->uuid);

        // Act
        $result = $handler->handle($command);

        // Assert
        $this->assertEquals('1234-test-uuid', $result->uuid);
    }

    public function test_it_throws_exception_if_book_not_found(): void
    {
        // Arrange
        $this->expectException(BookNotFoundException::class);
        $this->expectExceptionMessage('Book not found');

        $command = new ReturnBookCommand(
            uuid: 'non-existent-uuid',
        );

        // Act
        $handler = $this->app->make(ReturnBook::class);
        $handler->handle($command);
    }

    public function test_it_throws_exception_if_book_is_not_borrowed(): void
    {
        // Arrange
        $author = Author::factory()->create();
        $book = Book::factory()->create([
            'uuid' => '1234-test-uuid',
            'available' => true,
            'borrower_name' => 'Someone Else',
            'author_id' => $author->id,
        ]);

        $this->expectException(BookIsNotBorrowedException::class);
        $this->expectExceptionMessage('Book is not borrowed');

        $command = new ReturnBookCommand(
            uuid: $book->uuid,
        );

        // Act
        $handler = $this->app->make(ReturnBook::class);
        $handler->handle($command);
    }
}
