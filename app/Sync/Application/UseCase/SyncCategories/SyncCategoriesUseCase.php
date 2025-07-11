<?php

declare(strict_types=1);

namespace App\Sync\Application\UseCase\SyncCategories;

use App\Documentation\Application\UseCase\UpdateCategories\UpdateCategoriesCommand;
use App\Documentation\Application\UseCase\UpdateCategories\UpdateCategoriesCommand\CategoryIndex;
use App\Shared\Domain\Bus\CommandBusInterface;
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
        $this->commands->send(new UpdateCategoriesCommand(
            version: $command->version,
            categories: $this->createCategoriesIndices($command->version),
            id: $command->id,
        ));
    }
}
