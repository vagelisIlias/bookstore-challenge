<?php

declare(strict_types=1);

namespace Tests\Feature\Modules\Books\Services\ShowBook;
use App\Modules\Books\Database\Book;
use App\Modules\Books\Database\BookRepository;
use App\Modules\Books\Exceptions\BookNotFoundException;
use App\Modules\Books\Services\ShowBook\ShowBookHandler;
use App\Modules\Books\Services\ShowBook\ShowBookQuery;
use Tests\TestCase;

final class ShowBookHandlerTest extends TestCase
{
    public function test_it_returns_book_if_found(): void
    {
        // Arrange
        $uuid = '1234-test-uuid';
        $mockBook = $this->createMock(Book::class);

        $mockRepo = $this->createMock(BookRepository::class);
        $mockRepo->method('findByUuid')->with($uuid)->willReturn($mockBook);

        $handler = new ShowBookHandler($mockRepo);
        $query = new ShowBookQuery($uuid);

        // $request->acceptsJson()
        $result = $handler->handle($query);

        // Assert
        $this->assertSame($mockBook, $result);
    }

    public function test_it_throws_exception_if_book_not_found(): void
    {
        // Arrange
        $uuid = 'non-existent-uuid';

        $mockRepo = $this->createMock(BookRepository::class);
        $mockRepo->method('findByUuid')->with($uuid)->willReturn(null);

        $handler = new ShowBookHandler($mockRepo);
        $query = new ShowBookQuery($uuid);

        $this->expectException(BookNotFoundException::class);
        $this->expectExceptionMessage('Book not found');

        // Act
        $handler->handle($query);
    }
}
