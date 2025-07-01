<?php

declare(strict_types=1);

namespace App\Domain\Shared\Bus;

interface EventBusInterface
{
    public function dispatch(object $event): void;
}
