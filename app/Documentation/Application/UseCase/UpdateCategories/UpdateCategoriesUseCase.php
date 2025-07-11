<?php

declare(strict_types=1);

namespace App\Documentation\Application\UseCase\UpdateCategories;

use App\Documentation\Application\UseCase\UpdateCategories\Event\CategoryCreated;
use App\Documentation\Application\UseCase\UpdateCategories\Event\CategoryRemoved;
use App\Documentation\Application\UseCase\UpdateCategories\Event\CategoryUpdated;
use App\Documentation\Application\UseCase\UpdateCategories\Event\UpdateCategoryEvent;
use App\Documentation\Application\UseCase\UpdateCategories\UpdateCategoriesCommand\CategoryIndex;
use App\Documentation\Domain\Category\Category;
use App\Documentation\Domain\Category\Repository\CategoryListProviderInterface;
use App\Documentation\Domain\Version\Repository\VersionByNameProviderInterface;
use App\Documentation\Domain\Version\Version;
use App\Shared\Domain\Bus\EventBusInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler(bus: 'command.bus')]
final readonly class UpdateCategoriesUseCase
{
    public function __construct(
        private VersionByNameProviderInterface $versionByNameProvider,
        private CategoryListProviderInterface $categoryListProvider,
        private EntityManagerInterface $em,
        private EventBusInterface $events,
    ) {}

    /**
     * @return array<non-empty-string, Category>
     */
    private function getDatabaseCategoriesGroupByName(Version $version): array
    {
        $result = [];

        foreach ($this->categoryListProvider->getAll($version) as $category) {
            $result[$category->title] = $category;
        }

        return $result;
    }

    /**
     * @return array<non-empty-string, CategoryIndex>
     */
    private function getCommandCategoriesGroupByName(UpdateCategoriesCommand $command): array
    {
        $result = [];

        foreach ($command->categories as $category) {
            $result[$category->name] = $category;
        }

        return $result;
    }

    public function __invoke(UpdateCategoriesCommand $command): void
    {
        $events = \iterator_to_array($this->process($command));

        foreach ($events as $event) {
            $this->events->dispatch($event);
        }
    }

    /**
     * @return iterable<array-key, UpdateCategoryEvent>
     */
    public function process(UpdateCategoriesCommand $command): iterable
    {
        $version = $this->versionByNameProvider->findVersionByName($command->version);

        if ($version === null) {
            // TODO: TBD An exception should be thrown?
            return [];
        }

        $databaseCategories = $this->getDatabaseCategoriesGroupByName($version);
        $commandCategories = $this->getCommandCategoriesGroupByName($command);

        $index = 0;
        foreach ($commandCategories as $commandCategory) {
            $order = \min($index++, 32767);

            $databaseCategory = $databaseCategories[$commandCategory->name] ?? null;

            // In case of category is not in database
            if ($databaseCategory === null) {
                $this->em->persist(new Category(
                    version: $version,
                    title: $commandCategory->name,
                    description: $commandCategory->description,
                    icon: $commandCategory->icon,
                    order: $order,
                    hash: $commandCategory->hash,
                ));

                yield new CategoryCreated(
                    version: $version->name,
                    name: $commandCategory->name,
                );

                continue;
            }

            // Skip in case hash is equals to the command one
            if ($databaseCategory->hash === $commandCategory->hash) {
                continue;
            }

            $databaseCategory->hash = $commandCategory->hash;
            $databaseCategory->order = $order;
            $databaseCategory->description = $commandCategory->description;
            $databaseCategory->icon = $commandCategory->icon;

            yield new CategoryUpdated(
                version: $version->name,
                name: $commandCategory->name,
            );
        }

        // Remove unexistence categories
        foreach ($databaseCategories as $databaseCategory) {
            $containsInCommand = isset($commandCategories[$databaseCategory->title]);

            if (!$containsInCommand) {
                $this->em->remove($databaseCategory);

                yield new CategoryRemoved(
                    version: $version->name,
                    name: $databaseCategory->title,
                );
            }
        }

        $this->em->flush();
    }
}
