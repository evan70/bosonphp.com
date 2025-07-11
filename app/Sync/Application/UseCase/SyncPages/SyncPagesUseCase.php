<?php

declare(strict_types=1);

namespace App\Sync\Application\UseCase\SyncPages;

use App\Documentation\Application\UseCase\UpdatePages\UpdatePagesCommand;
use App\Documentation\Application\UseCase\UpdatePages\UpdatePagesIndexCommand\PageIndex;
use App\Shared\Domain\Bus\CommandBusInterface;
use App\Sync\Domain\Category\ExternalCategory;
use App\Sync\Domain\Category\Repository\ExternalCategoriesListProviderInterface;
use App\Sync\Domain\ExternalDocument;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler(bus: 'command.bus')]
final readonly class SyncPagesUseCase
{
    public function __construct(
        private ExternalCategoriesListProviderInterface $categoriesListProvider,
        private CommandBusInterface $commands,
    ) {}

    private function findCategory(SyncPagesCommand $command): ?ExternalCategory
    {
        $categories = $this->categoriesListProvider->getAll($command->version);

        foreach ($categories as $category) {
            if ($category->name === $command->category) {
                return $category;
            }
        }

        return null;
    }

    /**
     * @return iterable<array-key, ExternalDocument>
     */
    private function getPages(SyncPagesCommand $command): iterable
    {
        $category = $this->findCategory($command);

        if ($category === null) {
            return [];
        }

        return $category->pages;
    }

    /**
     * @return list<PageIndex>
     */
    private function createPagesIndices(SyncPagesCommand $command): array
    {
        $result = [];

        foreach ($this->getPages($command) as $page) {
            $result[] = new PageIndex(
                hash: $page->hash,
                name: $page->name,
            );
        }

        return $result;
    }

    public function __invoke(SyncPagesCommand $command): void
    {
        $indices = $this->createPagesIndices($command);

        $this->commands->send(new UpdatePagesCommand(
            version: $command->version,
            category: $command->category,
            pages: $indices,
        ));
    }
}
