<?php

declare(strict_types=1);

namespace App\Sync\Application\UseCase\SyncVersions;

use App\Documentation\Application\UseCase\UpdateVersionsIndex\UpdateVersionsIndexCommand;
use App\Documentation\Application\UseCase\UpdateVersionsIndex\UpdateVersionsIndexCommand\VersionIndex;
use App\Shared\Domain\Bus\CommandBusInterface;
use App\Sync\Application\UseCase\SyncCategories\SyncCategoriesCommand;
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
        $indices = $this->createVersionIndices();

        $this->commands->send(new UpdateVersionsIndexCommand(
            versions: $indices,
            id: $command->id,
        ));

        foreach ($indices as $index) {
            $this->commands->send(new SyncCategoriesCommand(
                version: $index->name,
                id: $command->id,
            ));
        }
    }
}
