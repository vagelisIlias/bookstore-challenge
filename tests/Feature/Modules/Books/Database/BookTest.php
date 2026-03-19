<?php

declare(strict_types=1);

namespace Tests\Feature\Modules\Books\Commands;
use App\Modules\Authors\Database\Author;
use App\Modules\Books\Database\Book;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

final class BookTest extends TestCase
{
    use RefreshDatabase;

    public function test_is_available_returns_true_when_book_is_available(): void
    {
        // Arrange
        $book = Book::factory()->create(['available' => true]);

        // Assert
        $this->assertTrue($book->isAvailable());
    }

    public function test_is_available_returns_false_when_book_is_not_available(): void
    {
        // Arrange
        $book = Book::factory()->create(['available' => false]);

        // Assert
        $this->assertFalse($book->isAvailable());
    }

    public function test_author_relation_returns_correct_author(): void
    {
        // Arrange
        $author = Author::factory()->create();
        $book = Book::factory()->for($author)->create();

        // Assert
        $this->assertEquals($author->id, $book->author->id);
        $this->assertEquals($author->name, $book->author->name);
    }

    public function test_unique_ids_returns_uuid(): void
    {
        // Arrange
        $book = new Book();

        // Assert
        $this->assertEquals(['uuid'], $book->uniqueIds());
    }
}
