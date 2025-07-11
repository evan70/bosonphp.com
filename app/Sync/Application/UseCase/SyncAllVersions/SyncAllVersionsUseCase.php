<?php

declare(strict_types=1);

namespace App\Sync\Application\UseCase\SyncAllVersions;

use App\Documentation\Application\UseCase\UpdateVersionsIndex\UpdateVersionsIndexCommand;
use App\Documentation\Application\UseCase\UpdateVersionsIndex\UpdateVersionsIndexCommand\IndexVersion;
use App\Shared\Domain\Bus\CommandBusInterface;
use App\Sync\Application\UseCase\SyncVersion\SyncVersionCommand;
use App\Sync\Domain\Version\Repository\ExternalVersionsListProviderInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler(bus: 'command.bus')]
final readonly class SyncAllVersionsUseCase
{
    public function __construct(
        private ExternalVersionsListProviderInterface $versions,
        private CommandBusInterface $commands,
    ) {}

    /**
     * @return list<IndexVersion>
     */
    private function createVersionIndices(): array
    {
        $indices = [];

        foreach ($this->versions->getAll() as $version) {
            $indices[] = new IndexVersion(
                version: $version->name,
                hash: $version->hash,
            );
        }

        return $indices;
    }

    public function __invoke(SyncAllVersionsCommand $command): void
    {
        $indices = $this->createVersionIndices();

        $this->commands->send(new UpdateVersionsIndexCommand(
            versions: $indices,
            id: $command->id,
        ));

        foreach ($indices as $index) {
            $this->commands->send(new SyncVersionCommand(
                version: $index->version,
                id: $command->id,
            ));
        }
    }
}
