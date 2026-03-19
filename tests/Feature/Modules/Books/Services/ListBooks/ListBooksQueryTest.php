<?php

declare(strict_types=1);

namespace Tests\Feature\Modules\Books\Services\ListBooks;
use App\Modules\Books\Services\ListBooks\ListBooksQuery;
use Tests\TestCase;

final class ListBooksQueryTest extends TestCase
{
    public function test_it_sets_per_page_and_available_values_correctly(): void
    {
        // Arrange
        $query = new ListBooksQuery(perPage: 5, available: true);

        // Assert
        $this->assertEquals(5, $query->perPage);
        $this->assertTrue($query->available);
    }
}
