<?php

declare(strict_types=1);

namespace Tests\Feature\Modules\Books\Commands;
use App\Modules\Books\Commands\ReturnBookCommand;
use Tests\TestCase;

final class ReturnBookCommandTest extends TestCase
{
    public function test_return_book_command_sets_uuid_correctly(): void
    {
        // Arrange
        $command = new ReturnBookCommand(
            uuid: '1234-Test',
        );

        // Assert
        $this->assertEquals('1234-Test', $command->uuid);
    }
}
