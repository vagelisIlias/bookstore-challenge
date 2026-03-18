<?php

declare(strict_types=1);

namespace Tests\Feature\Modules\Authors\Database;

use Tests\TestCase;
use App\Modules\Authors\Database\AuthorRepository;
use App\Modules\Authors\Services\CreateAuthors\CreateAuthorDto;
use Illuminate\Foundation\Testing\RefreshDatabase;

final class EloquentAuthorRepositoryTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_can_find_all_authors(): void
    {
        // Arrange
        $repository = $this->app->make(AuthorRepository::class);

        $repository->storeAuthor(new CreateAuthorDto(name: 'Author 1'));
        $repository->storeAuthor(new CreateAuthorDto(name: 'Author 2'));
        $repository->storeAuthor(new CreateAuthorDto(name: 'Author 3'));

        // Act
        $results = $repository->findAllAuthors(1);

        // Assert
        $this->assertEquals(3, $results->total());
    }

    public function test_it_can_find_author_by_name(): void
    {
        // Arrange
        $name = 'Author 1';
        $repository = $this->app->make(AuthorRepository::class);

        $repository->storeAuthor(new CreateAuthorDto(name: $name));

        // Act
        $result = $repository->findByName($name);

        // Assert
        $this->assertNotNull($result);
        $this->assertEquals($name, $result->name);
    }

    public function test_it_can_stores_authors(): void
    {
        // Arrange
        $name = 'Author 1';
        $repository = $this->app->make(AuthorRepository::class);

        // Act
        $author = $repository->storeAuthor(new CreateAuthorDto(name: $name));

        // Assert
        $this->assertEquals($name, $author->name);
        $this->assertDatabaseHas('authors', [
            'name' => $name
        ]);

        $this->assertNotNull($author->uuid);
    }
}
