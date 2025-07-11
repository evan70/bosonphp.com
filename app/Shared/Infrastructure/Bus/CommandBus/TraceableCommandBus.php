<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\Bus\CommandBus;

use App\Shared\Domain\Bus\CommandBusInterface;
use Symfony\Component\Stopwatch\Stopwatch;

final readonly class TraceableCommandBus implements CommandBusInterface
{
    public function __construct(
        private CommandBusInterface $delegate,
        private Stopwatch $stopwatch,
    ) {}

    public function send(object $command): void
    {
        $span = $this->stopwatch->start($command::class, 'command.bus');

        $this->delegate->send($command);

        $span->stop();
    }
}
