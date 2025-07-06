<?php

declare(strict_types=1);

namespace App\Infrastructure\Bus\CommandBus;

use App\Domain\Shared\Bus\CommandBusInterface;

abstract readonly class CommandBus implements CommandBusInterface {}
