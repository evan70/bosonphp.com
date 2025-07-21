<?php

declare(strict_types=1);

namespace App\Documentation\Domain\Category\Service\CategoriesChangeSetComputer;

use App\Documentation\Domain\Category\Event\CategoryUpdated;
use App\Documentation\Domain\Version\Version;

final readonly class CategoriesToUpdateComputer extends CategoriesComputer
{
    public function process(Version $version, array $existing, array $updated): iterable
    {
        $index = 0;

        foreach ($updated as $info) {
            $order = \min($index++, 32767);

            // Fetch stored entity from index
            $existingCategory = $existing[$info->name] ?? null;

            // Skip in case of category is not defined
            if ($existingCategory === null) {
                continue;
            }

            // Skip in case hash is equals to the updated one
            if ($info->hash === $existingCategory->hash) {
                continue;
            }

            $existingCategory->hash = $info->hash;
            $existingCategory->order = $order;
            $existingCategory->description = $info->description;
            $existingCategory->icon = $info->icon;

            yield $existingCategory => new CategoryUpdated($version->name, $info->name);
        }
    }
}
