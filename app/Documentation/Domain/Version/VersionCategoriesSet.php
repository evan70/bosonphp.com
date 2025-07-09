<?php

declare(strict_types=1);

namespace App\Documentation\Domain\Version;

use App\Documentation\Domain\Category\Category;
use Local\Component\Set\RelationSet;

/**
 * @template-extends RelationSet<Version, Category>
 */
final class VersionCategoriesSet extends RelationSet
{
    protected function shouldAdd(mixed $entry): bool
    {
        if ($entry->version !== $this->parent) {
            $entry->version = $this->parent;
        }

        return parent::shouldAdd($entry);
    }
}
