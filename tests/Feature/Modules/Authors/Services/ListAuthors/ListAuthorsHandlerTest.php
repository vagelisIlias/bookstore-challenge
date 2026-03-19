<?php

declare(strict_types=1);

namespace Tests\Feature\Modules\Authors\Services\ListAuthors;

use App\Modules\Authors\Commands\CreateAuthorCommand;
use App\Modules\Authors\Database\AuthorRepository;
use App\Modules\Authors\Services\ListAuthors\ListAuthorsHandler;
use App\Modules\Authors\Services\ListAuthors\ListAuthorsQuery;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

final class ListAuthorsHandlerTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_can_list_all_authors(): void
    {
        // Arrange
        $perPage = 2;
        $dto = new ListAuthorsQuery(perPage: $perPage);
        $repository = $this->app->make(AuthorRepository::class);
        $handler = $this->app->make(ListAuthorsHandler::class);

        $repository->storeAuthor(new CreateAuthorCommand('Author 1'));
        $repository->storeAuthor(new CreateAuthorCommand('Author 2'));
        $repository->storeAuthor(new CreateAuthorCommand('Author 3'));

        // Act
        $results = $handler->handle($dto);

        // Assert
        $this->assertEquals(3, $results->total());
        $this->assertCount(2, $results->items());
    }
}
