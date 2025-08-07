<?php

declare(strict_types=1);

namespace App\Documentation\Domain\Category\Service\CategoriesChangeSetComputer;

use App\Documentation\Domain\Category\Category;
use App\Documentation\Domain\Category\Event\CategoryCreated;
use App\Documentation\Domain\Version\Version;

/**
 * Computes which categories need to be created based on external data.
 */
final readonly class CategoriesToCreateComputer implements CategoriesComputerInterface
{
    /**
     * Determines which categories are missing in the system
     * and should be created.
     */
    public function process(Version $version, array $existing, array $updated): iterable
    {
        $index = 0;

        foreach ($updated as $info) {
            $order = \min($info->order ?? $index++, 32767);

            // Fetch stored entity from index
            $existingCategory = $existing[$info->name] ?? null;

            // Skip in case of category is present
            if ($existingCategory !== null) {
                continue;
            }

            $category = new Category(
                version: $version,
                title: $info->name,
                description: $info->description,
                icon: $info->icon,
                order: $order,
                hash: $info->hash,
            );

            // Create an entity
            yield $category => new CategoryCreated($version->name, $info->name);
        }
    }
}
