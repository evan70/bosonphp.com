<?php

declare(strict_types=1);

namespace App\Documentation\Domain\Service;

use App\Documentation\Domain\Category\Category;
use App\Documentation\Domain\Page;
use App\Documentation\Domain\Service\PagesChangeSetComputer\PagesToCreateComputer;
use App\Documentation\Domain\Service\PagesChangeSetComputer\PagesToRemoveComputer;
use App\Documentation\Domain\Service\PagesChangeSetComputer\PagesToUpdateComputer;

final readonly class PagesChangeSetComputer
{
    public function __construct(
        private PagesToUpdateComputer $updates,
        private PagesToCreateComputer $creations,
        private PagesToRemoveComputer $removements,
    ) {}

    /**
     * Groups system pages by their title for efficient lookup.
     *
     * @param iterable<mixed, Page> $pages
     *
     * @return array<non-empty-string, Page>
     */
    private function pagesGroupByUri(iterable $pages): array
    {
        $result = [];

        foreach ($pages as $entity) {
            $result[$entity->uri] = $entity;
        }

        \ksort($result);

        return $result;
    }

    /**
     * @param non-empty-string $name
     *
     * @return non-empty-string
     */
    private function pageInfoNameToUri(string $name): string
    {
        /** @var non-empty-string */
        return \pathinfo($name, \PATHINFO_FILENAME);
    }

    /**
     * Groups external page information by name for efficient lookup.
     *
     * @param iterable<mixed, PageInfo> $pages
     *
     * @return array<non-empty-string, PageInfo>
     */
    private function pageInfosGroupByUri(iterable $pages): array
    {
        $result = [];

        foreach ($pages as $info) {
            $index = match (true) {
                $info instanceof DocumentInfo => $this->pageInfoNameToUri($info->path),
                $info instanceof LinkInfo => $info->uri,
                default => throw new \InvalidArgumentException(\sprintf(
                    'Unsupported page info type %s',
                    $info::class,
                )),
            };

            $result[$index] = $info;
        }

        \ksort($result);

        return $result;
    }

    /**
     * Computes the plan of changes (created, updated, removed, events) to synchronize
     * system categories with the provided external category data.
     *
     * @param iterable<mixed, PageInfo> $updated External category data to compare against
     */
    public function compute(Category $category, iterable $updated): PagesChangePlan
    {
        $oldPagesIndex = $this->pagesGroupByUri($category->pages);
        $newPagesIndex = $this->pageInfosGroupByUri($updated);

        $createdPages = [];
        $updatedPages = [];
        $removedPages = [];
        $events = [];

        foreach ($this->updates->process($category, $oldPagesIndex, $newPagesIndex) as $entity => $event) {
            $updatedPages[$entity->uri] = $entity;
            $events[] = $event;
        }

        foreach ($this->creations->process($category, $oldPagesIndex, $newPagesIndex) as $entity => $event) {
            $createdPages[$entity->uri] = $entity;
            $events[] = $event;
        }

        foreach ($this->removements->process($category, $oldPagesIndex, $newPagesIndex) as $entity => $event) {
            $removedPages[$entity->uri] = $entity;
            $events[] = $event;
        }

        return new PagesChangePlan(
            updated: $updatedPages,
            created: $createdPages,
            removed: $removedPages,
            events: $events,
        );
    }
}
