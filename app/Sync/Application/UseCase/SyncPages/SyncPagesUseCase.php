<?php

declare(strict_types=1);

namespace App\Sync\Application\UseCase\SyncPages;

use App\Documentation\Application\UseCase\UpdatePages\UpdatePagesCommand;
use App\Documentation\Application\UseCase\UpdatePages\UpdatePagesIndexCommand\DocumentIndex;
use App\Documentation\Application\UseCase\UpdatePages\UpdatePagesIndexCommand\LinkIndex;
use App\Documentation\Application\UseCase\UpdatePages\UpdatePagesIndexCommand\PageIndex;
use App\Shared\Domain\Bus\CommandBusInterface;
use App\Shared\Domain\Bus\CommandId;
use App\Sync\Domain\Category\ExternalCategory;
use App\Sync\Domain\Category\Repository\ExternalCategoriesListProviderInterface;
use App\Sync\Domain\ExternalDocument;
use App\Sync\Domain\ExternalLink;
use App\Sync\Domain\ExternalPage;
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
     * @return iterable<array-key, ExternalPage>
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
    private function createPageIndices(SyncPagesCommand $command): array
    {
        $result = [];

        foreach ($this->getPages($command) as $page) {
            $result[] = match (true) {
                $page instanceof ExternalDocument => new DocumentIndex(
                    hash: $page->hash,
                    path: $page->path,
                ),
                $page instanceof ExternalLink => new LinkIndex(
                    hash: $page->hash,
                    uri: $page->uri,
                ),
                default => throw new \InvalidArgumentException(\sprintf(
                    'Unsupported external page type %s',
                    $page::class,
                )),
            };
        }

        return $result;
    }

    public function __invoke(SyncPagesCommand $command): void
    {
        $indices = $this->createPageIndices($command);

        $this->commands->send(new UpdatePagesCommand(
            version: $command->version,
            category: $command->category,
            pages: $indices,
            id: CommandId::createFrom($command->id),
        ));
    }
}
