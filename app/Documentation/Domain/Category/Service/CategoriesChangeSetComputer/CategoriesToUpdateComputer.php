<?php

declare(strict_types=1);

namespace App\Documentation\Domain\Category\Service\CategoriesChangeSetComputer;

use App\Documentation\Domain\Category\Event\CategoryUpdated;
use App\Documentation\Domain\Version\Version;

/**
 * Computes which categories need to be updated based on external data.
 */
final readonly class CategoriesToUpdateComputer implements CategoriesComputerInterface
{
    /**
     * Determines which categories should be updated.
     */
    public function process(Version $version, array $existing, array $updated): iterable
    {
        $index = 0;

        foreach ($updated as $info) {
            $order = \min($info->order ?? $index++, 32767);

            // Fetch stored entity from index
            $existingCategory = $existing[$info->name] ?? null;

            // Skip in case of category is not defined
            if ($existingCategory === null) {
                continue;
            }

            // Category hash is equivalent to main navigation
            // page hash, this is incorrect.
            // if ($info->hash === $existingCategory->hash) {
            //     continue;
            // }

            $existingCategory->hash = $info->hash;
            $existingCategory->order = $order;
            $existingCategory->description = $info->description;
            $existingCategory->icon = $info->icon;

            yield $existingCategory => new CategoryUpdated($version->name, $info->name);
        }
    }
}
