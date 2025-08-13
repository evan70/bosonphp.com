<?php

declare(strict_types=1);

namespace App\Documentation\Domain\Category\Service\CategoriesChangeSetComputer;

use App\Documentation\Domain\Category\Event\CategoryRemoved;
use App\Documentation\Domain\Version\Version;

/**
 * Computes which categories need to be removed based on external data.
 */
final readonly class CategoriesToRemoveComputer implements CategoriesComputerInterface
{
    /**
     * Determines which categories should be removed.
     */
    public function process(Version $version, array $existing, array $updated): iterable
    {
        foreach ($version->categories as $category) {
            // Fetch updated entity from index
            $removedCategory = $updated[$category->title] ?? null;

            // Skip in case of category is present
            if ($removedCategory !== null) {
                continue;
            }

            yield $category => new CategoryRemoved($version->name, $category->title);
        }
    }
}
