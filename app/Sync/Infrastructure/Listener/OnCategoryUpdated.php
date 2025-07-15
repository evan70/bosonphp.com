<?php

declare(strict_types=1);

namespace App\Sync\Infrastructure\Listener;

use App\Documentation\Domain\Category\Event\CategoryUpdated;
use App\Shared\Domain\Bus\CommandBusInterface;
use App\Shared\Domain\Bus\CommandId;
use App\Sync\Application\UseCase\SyncPages\SyncPagesCommand;
use Symfony\Component\EventDispatcher\Attribute\AsEventListener;

#[AsEventListener]
final readonly class OnCategoryUpdated
{
    public function __construct(
        private CommandBusInterface $commands,
    ) {}

    public function __invoke(CategoryUpdated $event): void
    {
        $this->commands->send(new SyncPagesCommand(
            version: $event->version,
            category: $event->name,
            id: CommandId::createFrom($event->id),
        ));
    }
}
