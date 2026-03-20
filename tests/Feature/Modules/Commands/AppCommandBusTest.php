<?php

declare(strict_types=1);

namespace Tests\Feature\Modules\Commands;

use App\Modules\Commands\AppCommandBus;
use Illuminate\Bus\Dispatcher;
use Tests\TestCase;

final class AppCommandBusTest extends TestCase
{
    public function test_it_can_dispatch_a_command(): void
    {
        // Arrange
        $dispatcher = $this->app->make(Dispatcher::class);
        $bus = new AppCommandBus($dispatcher);

        $command = new class {
            public string $value = 'test';
        };

        $handler = new class {
            public function handle($command)
            {
                return $command->value;
            }
        };

        $dispatcher->map([
            get_class($command) => get_class($handler),
        ]);

        $this->app->instance(get_class($handler), $handler);

        // Act
        $result = $bus->dispatch($command);

        // Assert
        $this->assertEquals('test', $result);
    }
}
