<?php

declare(strict_types=1);

namespace App\Sync\Application\UseCase\SyncVersion;

use App\Documentation\Application\UseCase\UpdateCategoriesIndex\UpdateCategoriesIndexCommand;
use App\Documentation\Application\UseCase\UpdateCategoriesIndex\UpdateCategoriesIndexCommand\IndexCategory;
use App\Shared\Domain\Bus\CommandBusInterface;
use App\Shared\Domain\Bus\QueryBusInterface;
use App\Sync\Application\UseCase\GetExternalDocumentByName\Exception\DocumentNotFoundException;
use App\Sync\Application\UseCase\GetExternalDocumentByName\GetExternalDocumentByNameOutput;
use App\Sync\Application\UseCase\GetExternalDocumentByName\GetExternalDocumentByNameQuery;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

/**
 * @phpstan-import-type NavigationArrayType from SyncVersionNavigation
 */
#[AsMessageHandler(bus: 'command.bus')]
final readonly class SyncVersionUseCase
{
    public function __construct(
        /**
         * @var non-empty-string
         */
        private string $navigation,
        private QueryBusInterface $queries,
        private CommandBusInterface $commands,
    ) {}

    /**
     * @param non-empty-string $version
     * @throws \JsonException
     */
    private function findNavigation(string $version): ?SyncVersionNavigation
    {
        try {
            /** @var GetExternalDocumentByNameOutput $page */
            $page = $this->queries->get(new GetExternalDocumentByNameQuery(
                version: $version,
                path: $this->navigation,
            ));
        } catch (DocumentNotFoundException) {
            // TODO: TBD An exception should be thrown?
            return null;
        }

        /** @var NavigationArrayType $navigation */
        $navigation = (array) \json_decode($page->document->content, true, flags: \JSON_THROW_ON_ERROR);

        return new SyncVersionNavigation(
            hash: $page->document->hash,
            categories: $navigation,
        );
    }

    /**
     * @return list<IndexCategory>
     */
    private function createCategoryIndices(SyncVersionNavigation $nav): array
    {
        $indices = [];

        foreach ($nav->categories as $category) {
            // Skip in case category is hidden
            if ($category['hidden'] ?? false) {
                continue;
            }

            $indices[] = new IndexCategory(
                category: $category['title'],
                hash: $nav->hash,
                description: $category['description'] ?? null,
                icon: $category['icon'] ?? null,
            );
        }

        return $indices;
    }

    public function __invoke(SyncVersionCommand $command): void
    {
        $navigation = $this->findNavigation($command->version);

        if ($navigation === null) {
            return;
        }

        $indices = $this->createCategoryIndices($navigation);

        $this->commands->send(new UpdateCategoriesIndexCommand(
            version: $command->version,
            categories: $indices,
            id: $command->id,
        ));
    }
}
