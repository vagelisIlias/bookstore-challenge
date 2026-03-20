<?php

namespace Tests\Feature\Modules\Books\Filters;

use App\Modules\Books\Database\Book;
use App\Modules\Books\Filters\ListBooksFilter;
use App\Modules\Authors\Database\Author;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

final class ListBooksFilterTest extends TestCase
{
    use RefreshDatabase;

    public function test_filters_by_availability(): void
    {
        // Arrange
        Book::factory()->create(['available' => true]);
        Book::factory()->create(['available' => false]);

        $filter = new ListBooksFilter(available: true);

        // Act
        $results = $filter->apply(Book::query())->get();

        // Assert
        $this->assertCount(1, $results);
        $this->assertTrue($results->first()->available);
    }

    public function test_filters_by_search(): void
    {
        // Arrange
        Book::factory()->create(['title' => 'Clean Code']);
        Book::factory()->create(['title' => 'Laravel Deep Dive']);

        $filter = new ListBooksFilter(search: 'Clean');

        // Act
        $results = $filter->apply(Book::query())->get();

        // Assert
        $this->assertCount(1, $results);
        $this->assertSame('Clean Code', $results->first()->title);
    }

    public function test_filters_by_author_uuid(): void
    {
        // Arrange
        $author = Author::factory()->create(['uuid' => 'author-1']);
        $otherAuthor = Author::factory()->create(['uuid' => 'author-2']);

        Book::factory()->create(['author_id' => $author->id]);
        Book::factory()->create(['author_id' => $otherAuthor->id]);

        $filter = new ListBooksFilter(authorUuid: 'author-1');

        // Act
        $results = $filter->apply(Book::query())->get();

        // Assert
        $this->assertCount(1, $results);
        $this->assertSame($author->id, $results->first()->author_id);
    }

    public function test_returns_all_when_no_filters_applied(): void
    {
        // Arrange
        Book::factory()->count(3)->create();

        $filter = new ListBooksFilter();

        // Act
        $results = $filter->apply(Book::query())->get();

        // Assert
        $this->assertCount(3, $results);
    }
}
