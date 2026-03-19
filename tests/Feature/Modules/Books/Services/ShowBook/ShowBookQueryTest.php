<?php

declare(strict_types=1);

namespace Tests\Feature\Modules\Books\Services\ShowBook;

use App\Modules\Books\Services\ShowBook\ShowBookQuery;
use Tests\TestCase;

final class ShowBookQueryTest extends TestCase
{
    public function test_list_author_query_sets_name_correctly(): void
    {
        // Arrange
        $query = new ShowBookQuery('1234-test');

        // Assert
        $this->assertEquals('1234-test', $query->uuid);
    }
}
