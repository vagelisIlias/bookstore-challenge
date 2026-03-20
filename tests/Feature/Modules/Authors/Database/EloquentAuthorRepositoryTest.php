<?php

declare(strict_types=1);

namespace Tests\Feature\Modules\Authors\Database;

use App\Modules\Authors\Database\Author;
use App\Modules\Authors\Database\AuthorRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

final class EloquentAuthorRepositoryTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_can_find_author_by_name(): void
    {
        // Arrange
        $name = 'Author Test';
        Author::factory()->create(['name' => $name]);
        $repository = $this->app->make(AuthorRepository::class);

        // Act
        $result = $repository->findByName($name);

        // Assert
        $this->assertNotNull($result);
        $this->assertEquals($name, $result->name);
    }
}
