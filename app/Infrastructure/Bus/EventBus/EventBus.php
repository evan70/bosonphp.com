<?php

declare(strict_types=1);

namespace App\Infrastructure\Bus\EventBus;

use App\Domain\Shared\Bus\EventBusInterface;

abstract readonly class EventBus implements EventBusInterface {}
