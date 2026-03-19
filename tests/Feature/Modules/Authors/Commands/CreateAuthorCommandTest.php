<?php

declare(strict_types=1);

namespace Tests\Feature\Modules\Authors\Commands;

use App\Modules\Authors\Commands\CreateAuthorCommand;
use Tests\TestCase;

final class CreateAuthorCommandTest extends TestCase
{
    public function test_create_author_command_sets_name_correctly(): void
    {
        // Arrange
        $command = new CreateAuthorCommand('Test Name');

        // Assert
        $this->assertEquals('Test Name', $command->name);
    }
}
