<?php

namespace App\Modules\Commands;

interface CommandBus
{
     public function dispatch(object $command): mixed;
}
