<?php

declare(strict_types=1);

namespace Tests\Feature\Modules\Books\Commands;

use App\Modules\Books\Commands\BorrowBookCommand;
use Tests\TestCase;

final class BorrowBookCommandTest extends TestCase
{
    public function test_borrow_book_command_sets_uuid_and_borrow_name_correctly(): void
    {
        // Arrange
        $command = new BorrowBookCommand(
            uuid: '1234-Test',
            borrowerName: 'Test Name'
        );

        // Assert
        $this->assertEquals('1234-Test', $command->uuid);
        $this->assertEquals('Test Name', $command->borrowerName);
    }
}
