<?php

declare(strict_types=1);

use App\Modules\Books\Database\BookRepository;
use App\Modules\Books\Services\ListBooks\ListBooksHandler;
use App\Modules\Books\Services\ListBooks\ListBooksQuery;
use Illuminate\Contracts\Pagination\LengthAwarePaginator as Paginator;
use PHPUnit\Framework\MockObject\MockObject;
use Tests\TestCase;


final class ListBooksHandlerTest extends TestCase
{
    private BookRepository&MockObject $mockRepo;
    private ListBooksHandler $handler;

    protected function setUp(): void
    {
        parent::setUp();
        $this->mockRepo = $this->createMock(BookRepository::class);
        $this->handler = new ListBooksHandler($this->mockRepo);
    }

    public function test_handle_calls_repository_with_no_filters(): void
    {
        // Arrange
        $query = new ListBooksQuery(perPage: 10, available: null);
        $mockPaginator = $this->createMock(Paginator::class);

        $this->mockRepo->expects($this->once())
            ->method('findAllBooks')
            ->with([], 10)
            ->willReturn($mockPaginator);

        // Act
        $result = $this->handler->handle($query);

        // Assert
        $this->assertSame($mockPaginator, $result);
    }

    public function test_handle_calls_repository_with_available_filter(): void
    {
        // Arrange
        $query = new ListBooksQuery(perPage: 5, available: true);
        $mockPaginator = $this->createMock(Paginator::class);

        $this->mockRepo->expects($this->once())
            ->method('findAllBooks')
            ->with(['available' => true], 5)
            ->willReturn($mockPaginator);

        // Act
        $result = $this->handler->handle($query);

        // Assert
        $this->assertSame($mockPaginator, $result);
    }
}
