<?php

declare(strict_types=1);

namespace Tests\Feature\Modules\Authors\Services\CreateAuthors;

use App\Modules\Authors\Database\Author;
use App\Modules\Authors\Database\AuthorRepository;
use App\Modules\Authors\Exceptions\AuthorAlreadyExistsException;
use App\Modules\Authors\Services\CreateAuthors\CreateAuthor;
use App\Modules\Authors\Services\CreateAuthors\CreateAuthorDto;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

final class CreateAuthorHandlerTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_can_create_a_new_author_if_not_exists(): void
    {
        // Arrange
        $name = 'Author';
        $dto = new CreateAuthorDto(name: $name);
        $author = new Author(['name' => $name]);

        $mockRepo = $this->createMock(AuthorRepository::class);

        $mockRepo->expects($this->once())
            ->method('findByName')
            ->with($name)
            ->willReturn(null);

        $mockRepo->expects($this->once())
            ->method('storeAuthor')
            ->with($dto)
            ->willReturn($author);

        $this->app->instance(AuthorRepository::class, $mockRepo);
        $handler = $this->app->make(CreateAuthor::class);

        // Act
        $result = $handler->handle($dto);

        // Assert
        $this->assertEquals($name, $result->name);
    }

    public function test_it_throws_exception_if_author_already_exists(): void
    {
        // Arrange
        $name = 'Author';
        $repository = $this->app->make(AuthorRepository::class);
        $repository->storeAuthor(new CreateAuthorDto(name: $name));

        $handler = $this->app->make(CreateAuthor::class);
        $dto = new CreateAuthorDto(name: $name);

        // Assert
        $this->expectException(AuthorAlreadyExistsException::class);
        $this->expectExceptionMessage('This Author already exists');

        // Act
        $handler->handle($dto);
    }
}
