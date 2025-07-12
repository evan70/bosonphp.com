<?php

declare(strict_types=1);

namespace App\Documentation\Application\UseCase\UpdatePages;

use App\Documentation\Application\UseCase\UpdatePages\Event\PageCreated;
use App\Documentation\Application\UseCase\UpdatePages\Event\PageRemoved;
use App\Documentation\Application\UseCase\UpdatePages\Event\PageUpdated;
use App\Documentation\Application\UseCase\UpdatePages\Event\UpdatePageEvent;
use App\Documentation\Application\UseCase\UpdatePages\UpdatePagesIndexCommand\PageIndex;
use App\Documentation\Domain\Category\Category;
use App\Documentation\Domain\Page;
use App\Documentation\Domain\PageDocument;
use App\Documentation\Domain\PageDocumentContentRendererInterface;
use App\Documentation\Domain\Version\Repository\VersionByNameProviderInterface;
use App\Shared\Domain\Bus\EventBusInterface;
use App\Shared\Domain\Bus\QueryBusInterface;
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
     * @return iterable<array-key, UpdatePageEvent>
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
                $content = $this->getContent($command->version, $commandPage->name);

                $this->em->persist(new PageDocument(
                    category: $category,
                    title: $this->getTitle($content, $commandPage->name),
                    uri: $commandPageUri,
                    content: $content,
                    contentRenderer: $this->contentRenderer,
                    order: $order,
                    hash: $commandPage->hash,
                ));

                yield new PageCreated(
                    version: $command->version,
                    category: $command->category,
                    name: $commandPage->name,
                );

                continue;
            }

            // Skip in case hash is equals to the command one
            if ($databasePage->hash === $commandPage->hash) {
                continue;
            }

            $databasePage->order = $order;
            $databasePage->hash = $commandPage->hash;

            if ($databasePage instanceof PageDocument) {
                $content = $this->getContent($command->version, $commandPage->name);
                $title = $this->getTitle($content, $commandPage->name);

                $databasePage->title = $title;
                $databasePage->content = $content;
            }

            $this->em->persist($databasePage);

            yield new PageUpdated(
                version: $command->version,
                category: $command->category,
                name: $commandPage->name,
            );
        }

        // Remove unexistence pages
        foreach ($databasePages as $databasePageUri => $databasePage) {
            $containsInCommand = isset($commandPages[$databasePageUri]);

            if ($containsInCommand) {
                continue;
            }

            $this->em->remove($databasePage);

            yield new PageRemoved(
                version: $command->version,
                category: $command->category,
                name: $databasePage->uri,
            );
        }

        $this->em->flush();
    }

    /**
     * @param non-empty-string $path
     * @return non-empty-string
     */
    private function getTitle(string $content, string $path): string
    {
        \preg_match('/^#+\h+(.+?)$/ium', $content, $matches);

        /** @var non-empty-string */
        return $matches[1] ?? new UnicodeString(\pathinfo($path, \PATHINFO_FILENAME))
            ->replaceMatches('/\W/', ' ')
            ->toString();
    }

    /**
     * @param non-empty-string $version
     * @param non-empty-string $path
     */
    private function getContent(string $version, string $path): string
    {
        /** @var GetExternalDocumentByNameOutput $result */
        $result = $this->queries->get(new GetExternalDocumentByNameQuery(
            version: $version,
            path: $path,
        ));

        return $result->document->content;
    }
}
