<?php

declare(strict_types=1);

namespace Tests\Feature\Modules\Authors\Services\ListAuthors;

use App\Modules\Authors\Database\AuthorRepository;
use App\Modules\Authors\Services\CreateAuthors\CreateAuthorDto;
use App\Modules\Authors\Services\ListAuthors\ListAuthors;
use App\Modules\Authors\Services\ListAuthors\ListAuthorsDto;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

final class ListAuthorsHandlerTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_can_list_all_authors(): void
    {
        // Arrange
        $perPage = 2;
        $dto = new ListAuthorsDto(perPage: $perPage);
        $repository = $this->app->make(AuthorRepository::class);
        $handler = $this->app->make(ListAuthors::class);

        $repository->storeAuthor(new CreateAuthorDto('Author 1'));
        $repository->storeAuthor(new CreateAuthorDto('Author 2'));
        $repository->storeAuthor(new CreateAuthorDto('Author 3'));

        // Act
        $results = $handler->handle($dto);

        // Assert
        $this->assertEquals(3, $results->total());
        $this->assertCount(2, $results->items());
    }
}
