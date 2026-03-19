<?php

declare(strict_types=1);

namespace Tests\Feature\Modules\Authors\Database;

use App\Modules\Authors\Commands\CreateAuthorCommand;
use App\Modules\Authors\Database\Author;
use App\Modules\Authors\Database\AuthorRepository;
use App\Modules\Books\Database\Book;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

final class AuthorTest extends TestCase
{
    use RefreshDatabase;

    public function test_author_can_have_books(): void
    {
        $repository = $this->app->make(AuthorRepository::class);
        $author = $repository->storeAuthor(new CreateAuthorCommand(name: 'Tolkien'));

        $this->assertInstanceOf(HasMany::class, $author->books());
    }

    public function test_book_relation_returns_correct_book(): void
    {
        $author = Author::factory()->create();
        $book = Book::factory()->for($author)->create();

        $this->assertEquals($author->id, $book->author->id);
        $this->assertEquals($author->name, $book->author->name);
    }

    public function test_unique_ids_returns_uuid(): void
    {
        $book = new Author();
        $this->assertEquals(['uuid'], $book->uniqueIds());
    }
}
