<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\Bus\QueryBus;

use App\Shared\Domain\Bus\QueryBusInterface;
use Symfony\Component\Messenger\Exception\HandlerFailedException;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Messenger\Stamp\HandledStamp;

final readonly class SymfonyMessengerQueryBus implements QueryBusInterface
{
    public function __construct(
        private MessageBusInterface $bus,
    ) {}

    public function get(object $query): mixed
    {
        try {
            $envelope = $this->bus->dispatch($query);
        } catch (HandlerFailedException $e) {
            foreach ($e->getWrappedExceptions() as $exception) {
                throw $exception;
            }

            throw $e;
        }

        return $envelope->last(HandledStamp::class)
            ?->getResult();
    }
}
