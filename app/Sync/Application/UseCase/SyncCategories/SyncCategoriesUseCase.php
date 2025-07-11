<?php

declare(strict_types=1);

namespace App\Sync\Application\UseCase\SyncCategories;

use App\Documentation\Application\UseCase\UpdateCategoriesIndex\UpdateCategoriesIndexCommand;
use App\Documentation\Application\UseCase\UpdateCategoriesIndex\UpdateCategoriesIndexCommand\CategoryIndex;
use App\Shared\Domain\Bus\CommandBusInterface;
use App\Sync\Application\UseCase\SyncPages\SyncPagesCommand;
use App\Sync\Domain\Category\Repository\ExternalCategoriesListProviderInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler(bus: 'command.bus')]
final readonly class SyncCategoriesUseCase
{
    public function __construct(
        private ExternalCategoriesListProviderInterface $categoriesListProvider,
        private CommandBusInterface $commands,
    ) {}

    /**
     * @param non-empty-string $version
     * @return list<CategoryIndex>
     */
    private function createCategoriesIndices(string $version): array
    {
        $indices = [];

        foreach ($this->categoriesListProvider->getAll($version) as $category) {
            $indices[] = new CategoryIndex(
                hash: $category->hash,
                name: $category->name,
                description: $category->description,
                icon: $category->icon,
            );
        }

        return $indices;
    }

    public function __invoke(SyncCategoriesCommand $command): void
    {
        $indices = $this->createCategoriesIndices($command->version);

        $this->commands->send(new UpdateCategoriesIndexCommand(
            version: $command->version,
            categories: $indices,
            id: $command->id,
        ));

        foreach ($indices as $index) {
            $this->commands->send(new SyncPagesCommand(
                version: $command->version,
                category: $index->name,
                id: $command->id,
            ));
        }
    }
}
