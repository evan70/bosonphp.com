<?php

declare(strict_types=1);

namespace App\Documentation\Domain\Category\Service\CategoriesChangeSetComputer;

use App\Documentation\Domain\Category\Event\CategoryRemoved;
use App\Documentation\Domain\Version\Version;

final readonly class CategoriesToRemoveComputer extends CategoriesComputer
{
    public function process(Version $version, array $existing, array $updated): iterable
    {
        foreach ($version->categories as $category) {
            // Fetch updated entity from index
            $updatedCategory = $updated[$category->title] ?? null;

            // Skip in case of category is present
            if ($updatedCategory !== null) {
                continue;
            }

            yield $category => new CategoryRemoved($version->name, $category->title);
        }
    }
}
