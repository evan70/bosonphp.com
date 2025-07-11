<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\Bus\EventBus;

use App\Shared\Domain\Bus\EventBusInterface;
use Psr\Log\LoggerInterface;

/**
 * @api
 *
 * @internal this is an internal library class, please do not use it in your code
 * @psalm-internal App\Shared\Infrastructure\Bus\EventBus
 */
final readonly class FailFreeEventBus implements EventBusInterface
{
    public function __construct(
        private EventBusInterface $delegate,
        private ?LoggerInterface $logger = null,
    ) {}

    public function dispatch(object $event): void
    {
        try {
            $this->delegate->dispatch($event);
        } catch (\Throwable $e) {
            $this->logger?->error($e);
        }
    }
}
