<?php

declare(strict_types=1);

namespace Tests\Feature\Modules\Books\Database\Query;
use App\Modules\Authors\Database\Author;
use App\Modules\Books\Database\Query\EloquentQueryRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

final class EloquentQueryRepositoryTest extends TestCase
{
    use RefreshDatabase;

    private EloquentQueryRepository $repository;

    protected function setUp(): void
    {
        parent::setUp();
        $this->repository = $this->app->make(EloquentQueryRepository::class);
    }

    public function test_it_can_find_author_by_uuid(): void
    {
        // Arrange
        $uuid = 'test-uuid';
        $name = 'Test-author';
        
        Author::factory()->create([
            'uuid' => $uuid,
            'name' =>$name
        ]);

        // Act
        $result = $this->repository->findAuthorByUuid($uuid);

        // Assert
        $this->assertEquals($uuid, $result->uuid);
        $this->assertEquals($name, $result->name);
    }
}
