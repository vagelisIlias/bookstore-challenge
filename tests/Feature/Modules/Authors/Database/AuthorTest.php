<?php

declare(strict_types=1);

namespace Tests\Feature\Modules\Authors\Database;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Modules\Authors\Database\AuthorRepository;
use App\Modules\Authors\Services\CreateAuthors\CreateAuthorDto;
use Illuminate\Database\Eloquent\Relations\HasMany;

final class AuthorTest extends TestCase
{
    use RefreshDatabase;

    public function test_author_can_have_books(): void
    {
        $repository = $this->app->make(AuthorRepository::class);
        $author = $repository->storeAuthor(new CreateAuthorDto(name: 'Tolkien'));

        $this->assertInstanceOf(HasMany::class, $author->books());
    }
}
