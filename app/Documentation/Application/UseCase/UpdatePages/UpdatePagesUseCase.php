<?php

declare(strict_types=1);

namespace App\Documentation\Application\UseCase\UpdatePages;

use App\Documentation\Application\UseCase\UpdatePages\UpdatePagesIndexCommand\PageIndex;
use App\Documentation\Domain\Category\Category;
use App\Documentation\Domain\Content\PageDocumentContentRendererInterface;
use App\Documentation\Domain\Event\PageDocumentEvent;
use App\Documentation\Domain\Event\PageDocumentRemoved;
use App\Documentation\Domain\Event\PageDocumentUpdated;
use App\Documentation\Domain\Page;
use App\Documentation\Domain\PageDocument;
use App\Documentation\Domain\PageTitleExtractorInterface;
use App\Documentation\Domain\Version\Repository\VersionByNameProviderInterface;
use App\Shared\Domain\Bus\EventBusInterface;
use App\Shared\Domain\Bus\EventId;
use App\Shared\Domain\Bus\QueryBusInterface;
use App\Shared\Domain\Bus\QueryId;
use App\Sync\Application\UseCase\GetExternalDocumentByName\GetExternalDocumentByNameOutput;
use App\Sync\Application\UseCase\GetExternalDocumentByName\GetExternalDocumentByNameQuery;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;
use Symfony\Component\String\UnicodeString;

#[AsMessageHandler(bus: 'command.bus')]
final readonly class UpdatePagesUseCase
{
    public function __construct(
        private VersionByNameProviderInterface $versionByNameProvider,
        private PageDocumentContentRendererInterface $contentRenderer,
        private PageTitleExtractorInterface $titleExtractor,
        private EntityManagerInterface $em,
        private QueryBusInterface $queries,
        private EventBusInterface $events,
    ) {}

    public function __invoke(UpdatePagesCommand $command): void
    {
        $events = \iterator_to_array($this->process($command));

        foreach ($events as $event) {
            $this->events->dispatch($event);
        }
    }

    private function findDatabaseCategory(UpdatePagesCommand $command): ?Category
    {
        $version = $this->versionByNameProvider->findVersionByName($command->version);

        if ($version === null) {
            return null;
        }

        foreach ($version->categories as $category) {
            if ($category->title === $command->category) {
                return $category;
            }
        }

        return null;
    }

    /**
     * @return array<non-empty-string, Page>
     */
    private function getDatabasePagesGroupByUri(Category $category): array
    {
        $result = [];

        foreach ($category->pages as $page) {
            $result[$page->uri] = $page;
        }

        return $result;
    }

    /**
     * @return array<non-empty-string, PageIndex>
     */
    private function getCommandPagesGroupByUri(UpdatePagesCommand $command): array
    {
        $result = [];

        foreach ($command->pages as $page) {
            $result[$this->getUriByPath($page)] = $page;
        }

        return $result;
    }

    /**
     * @return non-empty-string
     */
    private function getUriByPath(PageIndex $index): string
    {
        /** @var non-empty-string */
        return \pathinfo($index->name, \PATHINFO_FILENAME);
    }

    /**
     * @return iterable<array-key, PageDocumentEvent>
     */
    public function process(UpdatePagesCommand $command): iterable
    {
        $category = $this->findDatabaseCategory($command);

        if ($category === null) {
            // TODO: TBD Version/Category Not Found exception should be thrown?
            return [];
        }

        $databasePages = $this->getDatabasePagesGroupByUri($category);
        $commandPages = $this->getCommandPagesGroupByUri($command);

        $index = 0;
        foreach ($commandPages as $commandPageUri => $commandPage) {
            $order = \min($index++, 32767);

            $databasePage = $databasePages[$commandPageUri] ?? null;

            // In case of category is not in database
            if ($databasePage === null) {
                $page = new PageDocument(
                    category: $category,
                    title: $commandPageUri,
                    uri: $commandPageUri,
                    content: $this->getContent($command, $commandPage->name),
                    contentRenderer: $this->contentRenderer,
                    order: $order,
                    hash: $commandPage->hash,
                );

                $page->title = $this->titleExtractor->extractTitle($page);

                $this->em->persist($page);

                yield new PageDocumentUpdated(
                    version: $command->version,
                    category: $command->category,
                    title: $page->title,
                    uri: $page->uri,
                    content: $page->content->value,
                    id: EventId::createFrom($command->id),
                );

                continue;
            }

            // Skip in case hash is equals to the command one
            if ($databasePage->hash === $commandPage->hash) {
                continue;
            }

            // TODO Add support of PageLinks
            if (!$databasePage instanceof PageDocument) {
                continue;
            }

            $databasePage->order = $order;
            $databasePage->hash = $commandPage->hash;
            $databasePage->content = $this->getContent($command, $commandPage->name);

            $this->em->persist($databasePage);

            yield new PageDocumentRemoved(
                version: $command->version,
                category: $command->category,
                title: $databasePage->title,
                uri: $commandPage->name,
                content: $databasePage->content->value,
                id: EventId::createFrom($command->id),
            );
        }

        // Remove unexistence pages
        foreach ($databasePages as $databasePageUri => $databasePage) {
            $containsInCommand = isset($commandPages[$databasePageUri]);

            if ($containsInCommand) {
                continue;
            }

            $this->em->remove($databasePage);

            // TODO Add support of PageLinks
            if (!$databasePage instanceof PageDocument) {
                continue;
            }

            yield new PageDocumentRemoved(
                version: $command->version,
                category: $command->category,
                title: $databasePage->title,
                uri: $databasePage->uri,
                content: $databasePage->content->value,
                id: EventId::createFrom($command->id),
            );
        }

        $this->em->flush();
    }

    /**
     * @param non-empty-string $path
     */
    private function getContent(UpdatePagesCommand $command, string $path): string
    {
        /** @var GetExternalDocumentByNameOutput $result */
        $result = $this->queries->get(new GetExternalDocumentByNameQuery(
            version: $command->version,
            path: $path,
            id: QueryId::createFrom($command->id),
        ));

        return $result->document->content;
    }
}
