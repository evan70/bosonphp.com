<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\Bus\EventBus;

use App\Shared\Domain\Bus\EventBusInterface;
use Symfony\Component\Stopwatch\Stopwatch;

final readonly class TraceableEventBus implements EventBusInterface
{
    public function __construct(
        private EventBusInterface $delegate,
        private Stopwatch $stopwatch,
    ) {}

    public function dispatch(object $event): void
    {
        $span = $this->stopwatch->start($event::class, 'event.bus');

        $this->delegate->dispatch($event);

        $span->stop();
    }
}
