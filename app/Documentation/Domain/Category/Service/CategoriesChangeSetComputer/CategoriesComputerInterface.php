<?php

declare(strict_types=1);

namespace App\Documentation\Domain\Category\Service\CategoriesChangeSetComputer;

use App\Documentation\Domain\Category\Category;
use App\Documentation\Domain\Category\Event\CategoryEvent;
use App\Documentation\Domain\Category\Service\CategoryInfo;
use App\Documentation\Domain\Version\Version;

/**
 * Interface for category change computation strategies (create, update, remove).
 */
interface CategoriesComputerInterface
{
    /**
     * Processes category changes between system and external data.
     *
     * @param array<non-empty-string, Category> $existing Existing categories in the system
     * @param array<non-empty-string, CategoryInfo> $updated External category data
     *
     * @return iterable<Category, CategoryEvent> Pairs of categories and their events
     */
    public function process(Version $version, array $existing, array $updated): iterable;
}
