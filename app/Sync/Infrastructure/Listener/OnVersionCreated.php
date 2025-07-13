<?php

declare(strict_types=1);

namespace App\Sync\Infrastructure\Listener;

use App\Documentation\Application\UseCase\UpdateVersions\Event\VersionCreated;
use App\Shared\Domain\Bus\CommandBusInterface;
use App\Shared\Domain\Bus\CommandId;
use App\Sync\Application\UseCase\SyncCategories\SyncCategoriesCommand;
use Symfony\Component\EventDispatcher\Attribute\AsEventListener;

#[AsEventListener]
final readonly class OnVersionCreated
{
    public function __construct(
        private CommandBusInterface $commands,
    ) {}

    public function __invoke(VersionCreated $event): void
    {
        $this->commands->send(new SyncCategoriesCommand(
            version: $event->name,
            id: CommandId::createFrom($event->id),
        ));
    }
}
