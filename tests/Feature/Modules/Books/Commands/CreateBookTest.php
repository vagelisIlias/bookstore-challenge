<?php

declare(strict_types=1);

namespace Tests\Feature\Modules\Books\Commands;
use App\Modules\Authors\Database\Author;
use App\Modules\Authors\Database\AuthorRepository;
use App\Modules\Books\Commands\CreateBook;
use App\Modules\Books\Database\Book;
use App\Modules\Books\Database\BookRepository;
use App\Modules\Books\Exceptions\BookAlreadyExistsException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

final class CreateBookTest extends TestCase
{
    use RefreshDatabase;

    public function test_creates_book_successfully(): void
    {
        // Arrange
        $bookRepository = $this->createMock(BookRepository::class);
        $authorRepository = $this->createMock(AuthorRepository::class);

        $bookRepository->method('findByIsbn')
            ->with('1234567890')
            ->willReturn(null);

        $author = new Author();
        $author->id = 1;

        $authorRepository->method('requireByUuid')
            ->with('author-uuid-123')
            ->willReturn($author);

        $bookRepository->expects($this->once())
            ->method('save')
            ->with($this->isInstanceOf(Book::class));

        $command = new CreateBook(
            'Clean Code',
            '1234567890',
            'author-uuid-123'
        );

        // Act
        $book = $command->handle($bookRepository, $authorRepository);

        // Assert
        $this->assertSame('Clean Code', $book->title);
        $this->assertSame('1234567890', $book->isbn);
    }

    public function test_it_throws_exception_if_book_already_exists(): void
    {
        // Arrange
        $bookRepository = $this->createMock(BookRepository::class);
        $authorRepository = $this->createMock(AuthorRepository::class);

        $existingBook = $this->createMock(Book::class);

        $bookRepository->method('findByIsbn')
            ->with('1234567890')
            ->willReturn($existingBook);

        $authorRepository->expects($this->never())
            ->method('requireByUuid');

        $this->expectException(BookAlreadyExistsException::class);

        $command = new CreateBook(
            'Clean Code',
            '1234567890',
            'author-uuid-123'
        );

        // Act
        $command->handle($bookRepository, $authorRepository);
    }
}
