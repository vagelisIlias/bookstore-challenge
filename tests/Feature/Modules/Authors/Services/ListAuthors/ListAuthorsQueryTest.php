<?php

declare(strict_types=1);

namespace Tests\Feature\Modules\Authors\Services\ListAuthors;

use App\Modules\Authors\Services\ListAuthors\ListAuthorsQuery;
use Tests\TestCase;

final class ListAuthorsQueryTest extends TestCase
{
    public function test_list_author_query_sets_name_correctly(): void
    {
        // Arrange
        $query = new ListAuthorsQuery(10);

        // Assert
        $this->assertEquals(10, $query->perPage);
    }
}
