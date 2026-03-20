<?php

declare(strict_types=1);

namespace Tests\Feature\Modules\Books\Commands;
use App\Modules\Authors\Database\Author;
use App\Modules\Books\Commands\CreateBookCommand;
use App\Modules\Books\Contracts\CreateBook;
use App\Modules\Books\Database\Book;
use App\Modules\Books\Database\BookRepository;
use App\Modules\Books\Database\Query\QueryRepository;
use App\Modules\Books\Exceptions\AuthorNotFoundException;
use App\Modules\Books\Exceptions\BookAlreadyExistsException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

final class CreateBookCommandHandlerTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_can_create_a_book(): void
    {
        // Arrange
        $author = Author::factory()->create();
        $command = new CreateBookCommand(
            title: '1984',
            isbn: '978-0451524935',
            authorUuid: 'author-uuid'
        );

        $book = Book::factory()->create([
            'uuid' => '1234-test-uuid',
            'title' => '1984',
            'isbn' => '978-0451524935',
            'available' => true,
            'borrower_name' => 'Nikolas',
            'author_id' => $author->id,
        ]);

        $bookRepo = $this->createMock(BookRepository::class);
        $queryRepo = $this->createMock(QueryRepository::class);

        $bookRepo->expects($this->once())
            ->method('findByIsbn')
            ->with($command->isbn)
            ->willReturn(null);

        $queryRepo->expects($this->once())
            ->method('findAuthorByUuid')
            ->with($command->authorUuid)
            ->willReturn($author);

        $bookRepo->expects($this->once())
            ->method('storeBook')
            ->with($command->title, $command->isbn, $author->id)
            ->willReturn($book);

        $this->app->instance(BookRepository::class, $bookRepo);
        $this->app->instance(QueryRepository::class, $queryRepo);

        $handler = $this->app->make(CreateBook::class);

        // Act
        $result = $handler->handle($command);

         // Assert
        $this->assertEquals('1984', $result->title);
        $this->assertEquals('978-0451524935', $result->isbn);
    }

    public function test_it_throws_exception_if_book_already_exists(): void
    {
        // Arrange
        $command = new CreateBookCommand(
            title: '1984',
            isbn: '978-0451524935',
            authorUuid: 'author-uuid'
        );

        $existingBook = new Book(['isbn' => '978-0451524935']);

        $bookRepo = $this->createMock(BookRepository::class);
        $queryRepo = $this->createMock(QueryRepository::class);

        $bookRepo->expects($this->once())
            ->method('findByIsbn')
            ->willReturn($existingBook);

        $this->app->instance(BookRepository::class, $bookRepo);
        $this->app->instance(QueryRepository::class, $queryRepo);

        $handler = $this->app->make(CreateBook::class);

        // Assert
        $this->expectException(BookAlreadyExistsException::class);
        $this->expectExceptionMessage('Book already exists');

        // Act
        $handler->handle($command);
    }

    public function test_it_throws_exception_if_author_not_found(): void
    {
        // Arrange
        $command = new CreateBookCommand(
            title: '1984',
            isbn: '978-0451524935',
            authorUuid: 'author-uuid'
        );

        $bookRepo = $this->createMock(BookRepository::class);
        $queryRepo = $this->createMock(QueryRepository::class);

        $bookRepo->expects($this->once())
            ->method('findByIsbn')
            ->willReturn(null);

        $queryRepo->expects($this->once())
            ->method('findAuthorByUuid')
            ->willReturn(null);

        $this->app->instance(BookRepository::class, $bookRepo);
        $this->app->instance(QueryRepository::class, $queryRepo);

        $handler = $this->app->make(CreateBook::class);

        // Assert
        $this->expectException(AuthorNotFoundException::class);
        $this->expectExceptionMessage('Author not found');
        
        // Act
        $handler->handle($command);
    }
}
