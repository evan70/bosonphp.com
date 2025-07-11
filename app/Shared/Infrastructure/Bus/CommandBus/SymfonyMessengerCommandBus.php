<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\Bus\CommandBus;

use App\Shared\Domain\Bus\CommandBusInterface;
use Symfony\Component\Messenger\Exception\HandlerFailedException;
use Symfony\Component\Messenger\MessageBusInterface;

final readonly class SymfonyMessengerCommandBus implements CommandBusInterface
{
    public function __construct(
        private MessageBusInterface $bus,
    ) {}

    public function send(object $command): void
    {
        try {
            $this->bus->dispatch($command);
        } catch (HandlerFailedException $e) {
            foreach ($e->getWrappedExceptions() as $exception) {
                throw $exception;
            }

            throw $e;
        }
    }
}
