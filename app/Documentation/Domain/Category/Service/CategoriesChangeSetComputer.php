<?php

declare(strict_types=1);

namespace App\Documentation\Domain\Category\Service;

use App\Documentation\Domain\Category\Category;
use App\Documentation\Domain\Category\Service\CategoriesChangeSetComputer\CategoriesToCreateComputer;
use App\Documentation\Domain\Category\Service\CategoriesChangeSetComputer\CategoriesToRemoveComputer;
use App\Documentation\Domain\Category\Service\CategoriesChangeSetComputer\CategoriesToUpdateComputer;
use App\Documentation\Domain\Version\Version;

final readonly class CategoriesChangeSetComputer
{
    public function __construct(
        private CategoriesToUpdateComputer $updates,
        private CategoriesToCreateComputer $creations,
        private CategoriesToRemoveComputer $removements,
    ) {}

    /**
     * @param iterable<mixed, Category> $categories
     *
     * @return array<non-empty-string, Category>
     */
    protected function categoriesGroupByTitle(iterable $categories): array
    {
        $result = [];

        foreach ($categories as $entity) {
            $result[$entity->title] = $entity;
        }

        \ksort($result);

        return $result;
    }

    /**
     * @param iterable<mixed, CategoryInfo> $categories
     *
     * @return array<non-empty-string, CategoryInfo>
     */
    protected function categoryInfosGroupByName(iterable $categories): array
    {
        $result = [];

        foreach ($categories as $info) {
            $result[$info->name] = $info;
        }

        \ksort($result);

        return $result;
    }

    /**
     * @param iterable<mixed, CategoryInfo> $updated external category data to
     *        compare against
     */
    public function compute(Version $version, iterable $updated): CategoriesChangePlan
    {
        $oldCategoriesIndex = $this->categoriesGroupByTitle($version->categories);
        $newCategoriesIndex = $this->categoryInfosGroupByName($updated);

        $createdCategories = [];
        $updatedCategories = [];
        $removedCategories = [];
        $events = [];

        foreach ($this->updates->process($version, $oldCategoriesIndex, $newCategoriesIndex) as $entity => $event) {
            $updatedCategories[$entity->title] = $entity;
            $events[] = $event;
        }

        foreach ($this->creations->process($version, $oldCategoriesIndex, $newCategoriesIndex) as $entity => $event) {
            $createdCategories[$entity->title] = $entity;
            $events[] = $event;
        }

        foreach ($this->removements->process($version, $oldCategoriesIndex, $newCategoriesIndex) as $entity => $event) {
            $removedCategories[$entity->title] = $entity;
            $events[] = $event;
        }

        return new CategoriesChangePlan(
            updated: $updatedCategories,
            created: $createdCategories,
            removed: $removedCategories,
            events: $events,
        );
    }
}
