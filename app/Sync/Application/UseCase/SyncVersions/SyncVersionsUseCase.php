<?php

declare(strict_types=1);

namespace App\Sync\Application\UseCase\SyncVersions;

use App\Documentation\Application\UseCase\UpdateVersions\UpdateVersionsCommand;
use App\Documentation\Application\UseCase\UpdateVersions\UpdateVersionsCommand\VersionIndex;
use App\Shared\Domain\Bus\CommandBusInterface;
use App\Sync\Domain\Version\Repository\ExternalVersionsListProviderInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler(bus: 'command.bus')]
final readonly class SyncVersionsUseCase
{
    public function __construct(
        private ExternalVersionsListProviderInterface $externalVersionsListProvider,
        private CommandBusInterface $commands,
    ) {}

    /**
     * @return list<VersionIndex>
     */
    private function createVersionIndices(): array
    {
        $indices = [];

        foreach ($this->externalVersionsListProvider->getAll() as $version) {
            $indices[] = new VersionIndex(
                hash: $version->hash,
                name: $version->name,
            );
        }

        return $indices;
    }

    public function __invoke(SyncVersionsCommand $command): void
    {
        $this->commands->send(new UpdateVersionsCommand(
            versions: $this->createVersionIndices(),
            id: $command->id,
        ));
    }
}
