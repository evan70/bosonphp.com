<?php

declare(strict_types=1);

namespace App\Documentation\Application\UseCase\UpdateCategoriesIndex;

use App\Documentation\Application\UseCase\UpdateCategoriesIndex\UpdateCategoriesIndexCommand\IndexCategory;
use App\Documentation\Domain\Category\Category;
use App\Documentation\Domain\Category\Repository\CategoryListProviderInterface;
use App\Documentation\Domain\Version\Repository\VersionByNameProviderInterface;
use App\Documentation\Domain\Version\Version;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler(bus: 'command.bus')]
final readonly class UpdateCategoriesIndexUseCase
{
    public function __construct(
        private VersionByNameProviderInterface $versionByNameProvider,
        private CategoryListProviderInterface $categoryListProvider,
        private EntityManagerInterface $em,
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
     * @return array<non-empty-string, IndexCategory>
     */
    private function getCommandCategoriesGroupByName(UpdateCategoriesIndexCommand $command): array
    {
        $result = [];

        foreach ($command->categories as $category) {
            $result[$category->category] = $category;
        }

        return $result;
    }

    public function __invoke(UpdateCategoriesIndexCommand $command): void
    {
        $version = $this->versionByNameProvider->findVersionByName($command->version);

        if ($version === null) {
            // TODO: TBD An exception should be thrown?
            return;
        }

        $databaseCategories = $this->getDatabaseCategoriesGroupByName($version);
        $commandCategories = $this->getCommandCategoriesGroupByName($command);

        $index = 0;
        foreach ($commandCategories as $commandCategory) {
            $order = \min($index++, 32767);

            $databaseCategory = $databaseCategories[$commandCategory->category] ?? null;

            // In case of category is not in database
            if ($databaseCategory === null) {
                $this->em->persist(new Category(
                    version: $version,
                    title: $commandCategory->category,
                    description: $commandCategory->description,
                    icon: $commandCategory->icon,
                    order: $order,
                ));

                continue;
            }

            $databaseCategory->order = $order;
            $databaseCategory->description = $commandCategory->description;
            $databaseCategory->icon = $commandCategory->icon;
        }

        // Remove unexistence categories
        foreach ($databaseCategories as $databaseCategory) {
            $containsInCommand = isset($commandCategories[$databaseCategory->title]);

            if (!$containsInCommand) {
                $this->em->remove($databaseCategory);
            }
        }

        $this->em->flush();
    }
}
