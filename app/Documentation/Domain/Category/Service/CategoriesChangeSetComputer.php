<?php

declare(strict_types=1);

namespace App\Documentation\Domain\Category\Service;

use App\Documentation\Domain\Category\Category;
use App\Documentation\Domain\Category\Service\CategoriesChangeSetComputer\CategoriesToCreateComputer;
use App\Documentation\Domain\Category\Service\CategoriesChangeSetComputer\CategoriesToRemoveComputer;
use App\Documentation\Domain\Category\Service\CategoriesChangeSetComputer\CategoriesToUpdateComputer;
use App\Documentation\Domain\Version\Version;

/**
 * Computes the set of changes (create, update, remove) required to synchronize
 * system categories with external category data.
 */
final readonly class CategoriesChangeSetComputer
{
    public function __construct(
        /**
         * Strategy for updating existing categories
         */
        private CategoriesToUpdateComputer $updates,
        /**
         * Strategy for creating new categories
         */
        private CategoriesToCreateComputer $creations,
        /**
         * Strategy for removing categories
         */
        private CategoriesToRemoveComputer $removements,
    ) {}

    /**
     * Groups system categories by their title for efficient lookup.
     *
     * @param iterable<mixed, Category> $categories
     *
     * @return array<non-empty-string, Category>
     */
    private function categoriesGroupByTitle(iterable $categories): array
    {
        $result = [];

        foreach ($categories as $entity) {
            $result[$entity->title] = $entity;
        }

        \ksort($result);

        return $result;
    }

    /**
     * Groups external category information by name for efficient lookup.
     *
     * @param iterable<mixed, CategoryInfo> $categories
     *
     * @return array<non-empty-string, CategoryInfo>
     */
    private function categoryInfosGroupByName(iterable $categories): array
    {
        $result = [];

        foreach ($categories as $info) {
            $result[$info->name] = $info;
        }

        \ksort($result);

        return $result;
    }

    /**
     * Computes the plan of changes (created, updated, removed, events) to synchronize
     * system categories with the provided external category data.
     *
     * @param iterable<mixed, CategoryInfo> $updated External category data to compare against
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
