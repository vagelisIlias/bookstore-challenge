<?php

declare(strict_types=1);

namespace Tests\Feature\Modules\Books\Commands;
use App\Modules\Books\Commands\CreateBookCommand;
use Tests\TestCase;

final class CreateBookCommandTest extends TestCase
{
    public function test_create_book_command_sets_title_and_isbn_and_author_uuid_correctly(): void
    {
        // Arrange
        $command = new CreateBookCommand(
            title: 'Title-test',
            isbn: 'Test-isbn',
            authorUuid: 'Test-uuid'
        );

        // Assert
        $this->assertEquals('Title-test', $command->title);
        $this->assertEquals('Test-isbn', $command->isbn);
        $this->assertEquals('Test-uuid', $command->authorUuid);
    }
}
