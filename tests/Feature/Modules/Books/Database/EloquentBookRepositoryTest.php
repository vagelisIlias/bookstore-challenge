<?php

declare(strict_types=1);

namespace Tests\Feature\Modules\Books\Database;

use App\Modules\Books\Database\Book;
use App\Modules\Books\Database\EloquentBookRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

final class EloquentBookRepositoryTest extends TestCase
{
    use RefreshDatabase;

    private EloquentBookRepository $repository;

    protected function setUp(): void
    {
        parent::setUp();
        $this->repository = new EloquentBookRepository(new Book());
    }

    public function test_returns_book_when_isbn_exists(): void
    {
        // Arrange
        $book = Book::factory()->create([
            'isbn' => '1234567890',
        ]);

        // Act
        $result = $this->repository->findByIsbn('1234567890');

        // Assert
        $this->assertNotNull($result);
        $this->assertSame($book->id, $result->id);
        $this->assertSame('1234567890', $result->isbn);
    }
}
