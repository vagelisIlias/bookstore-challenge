<?php

declare(strict_types=1);

namespace Tests\Feature\Modules\Books\Services\UpdateBook;

use App\Modules\Books\Services\UpdateBook\UpdateBookDto;
use Tests\TestCase;

final class UpdateBookDtoTest extends TestCase
{
    public function test_it_sets_properties_correctly(): void
    {
        // Arrange
        $isbn = '978-1234567890';
        $available = false;
        $borrowerName = 'John Doe';
        $isActive = 1;

        $dto = new UpdateBookDto(
            isbn: $isbn,
            available: $available,
            borrowerName: $borrowerName,
            isActive: $isActive
        );

        // Assert
        $this->assertSame($isbn, $dto->isbn);
        $this->assertSame($available, $dto->available);
        $this->assertSame($borrowerName, $dto->borrowerName);
        $this->assertSame($isActive, $dto->isActive);
    }

    public function test_it_allows_null_values(): void
    {
        // Arrange
        $dto = new UpdateBookDto();

        // Assert
        $this->assertNull($dto->isbn);
        $this->assertNull($dto->available);
        $this->assertNull($dto->borrowerName);
        $this->assertNull($dto->isActive);
    }
}
