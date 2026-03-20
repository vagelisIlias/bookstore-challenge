<?php

declare(strict_types=1);

namespace Tests\Feature\Modules\Authors\Commands;

use App\Modules\Authors\Commands\CreateAuthor;
use App\Modules\Authors\Database\Author;
use App\Modules\Authors\Database\AuthorRepository;
use App\Modules\Authors\Exceptions\AuthorAlreadyExistsException;
use Tests\TestCase;

final class CreateAuthorTest extends TestCase
{
    public function test_creates_author_successfully(): void
    {
        // Arrange
        $repository = $this->createMock(AuthorRepository::class);

        $repository
            ->method('findByName')
            ->with('John Doe')
            ->willReturn(null);

        $repository
            ->expects($this->once())
            ->method('save')
            ->with($this->isInstanceOf(Author::class));

        $command = new CreateAuthor('John Doe');
        // Act
        $author = $command->handle($repository);

        // Assert
        $this->assertInstanceOf(Author::class, $author);
        $this->assertSame('John Doe', $author->name);
    }
    public function test_throws_exception_if_author_exists(): void
    {
        // Arrange
        $repository = $this->createMock(AuthorRepository::class);

        $existingAuthor = Author::new('John Doe');

        $repository
            ->method('findByName')
            ->with('John Doe')
            ->willReturn($existingAuthor);

        $this->expectException(AuthorAlreadyExistsException::class);

        // Act
        $command = new CreateAuthor('John Doe');
        $command->handle($repository);
    }
}
