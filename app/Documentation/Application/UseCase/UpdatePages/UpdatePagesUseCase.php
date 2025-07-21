<?php

declare(strict_types=1);

namespace App\Documentation\Application\UseCase\UpdatePages;

use App\Documentation\Application\UseCase\UpdatePages\UpdatePagesIndexCommand\DocumentIndex;
use App\Documentation\Application\UseCase\UpdatePages\UpdatePagesIndexCommand\LinkIndex;
use App\Documentation\Domain\Category\Category;
use App\Documentation\Domain\Event\PageEvent;
use App\Documentation\Domain\Service\DocumentInfo;
use App\Documentation\Domain\Service\LinkInfo;
use App\Documentation\Domain\Service\PageInfo;
use App\Documentation\Domain\Service\PagesChangeSetComputer;
use App\Documentation\Domain\Version\Repository\VersionByNameProviderInterface;
use App\Shared\Domain\Bus\EventBusInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler(bus: 'command.bus')]
final readonly class UpdatePagesUseCase
{
    public function __construct(
        private VersionByNameProviderInterface $versionByNameProvider,
        private PagesChangeSetComputer $pagesChangeSetComputer,
        private EntityManagerInterface $em,
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
     * @return list<PageInfo>
     */
    private function getExternalPagesInfoList(UpdatePagesCommand $command): array
    {
        $result = [];

        foreach ($command->pages as $index) {
            $result[] = match (true) {
                $index instanceof DocumentIndex => new DocumentInfo(
                    hash: $index->hash,
                    path: $index->path,
                ),
                $index instanceof LinkIndex => new LinkInfo(
                    hash: $index->hash,
                    uri: $index->uri,
                ),
                default => throw new \InvalidArgumentException(\sprintf(
                    'Unsupported page index type %s',
                    $index::class,
                )),
            };
        }

        return $result;
    }

    /**
     * @return iterable<array-key, PageEvent>
     */
    public function process(UpdatePagesCommand $command): iterable
    {
        $category = $this->findDatabaseCategory($command);

        if ($category === null) {
            // TODO: TBD Version/Category Not Found exception should be thrown?
            return [];
        }

        $pagesChangeSetPlan = $this->pagesChangeSetComputer->compute(
            category: $category,
            updated: $this->getExternalPagesInfoList($command),
        );

        foreach ($pagesChangeSetPlan->updated as $updatedPage) {
            $this->em->persist($updatedPage);
        }

        foreach ($pagesChangeSetPlan->created as $createdPage) {
            $this->em->persist($createdPage);
        }

        foreach ($pagesChangeSetPlan->removed as $removedPage) {
            $this->em->remove($removedPage);
        }

        yield from $pagesChangeSetPlan->events;

        $this->em->flush();
    }
}
