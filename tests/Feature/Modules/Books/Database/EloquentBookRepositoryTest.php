<?php

declare(strict_types=1);

namespace Tests\Feature\Modules\Books\Database;
use App\Modules\Books\Database\Book;
use App\Modules\Books\Database\EloquentBookRepository;
use App\Modules\Books\Services\UpdateBook\UpdateBookDto;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

final class EloquentBookRepositoryTest extends TestCase
{
    use RefreshDatabase;

    private EloquentBookRepository $repository;

    protected function setUp(): void
    {
        parent::setUp();
        $this->repository = $this->app->make(EloquentBookRepository::class);
    }

    public function test_find_all_books_returns_paginated_results(): void
    {
        // Arrange
        Book::factory()->count(5)->create(['available' => true]);
        Book::factory()->count(3)->create(['available' => false]);

        $paginated = $this->repository->findAllBooks(['available' => true], 10);

        // Assert
        $this->assertCount(5, $paginated->items());
    }

    public function test_find_by_uuid_returns_correct_book(): void
    {
        // Arrange
        $book = Book::factory()->create(['available' => true]);
        $found = $this->repository->findByUuid($book->uuid);

        // Assert
        $this->assertEquals($book->uuid, $found->uuid);
    }

    public function test_update_book_updates_fields_correctly(): void
    {
        // Arrange
        $book = Book::factory()->create([
            'isbn' => '1111',
            'available' => false,
            'borrower_name' => null,
            'is_active' => false,
        ]);

        $dto = new UpdateBookDto(
            isbn: '1234-test',
            available: false,
            borrowerName: 'Nikolas',
            isActive: null
        );

        // Act
        $updated = $this->repository->updateBook($book, $dto);

        // Assert
        $this->assertEquals('1234-test', $updated->isbn);
        $this->assertFalse($updated->available);
        $this->assertEquals('Nikolas', $updated->borrower_name);
        $this->assertFalse($updated->is_active);
    }
}
