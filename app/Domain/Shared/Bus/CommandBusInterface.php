<?php

declare(strict_types=1);

namespace App\Domain\Shared\Bus;

interface CommandBusInterface
{
    public function send(object $command): mixed;
}
