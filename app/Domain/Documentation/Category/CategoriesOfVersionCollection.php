<?php

declare(strict_types=1);

namespace App\Domain\Documentation\Category;

use App\Domain\Documentation\Version\Version;
use Local\Component\Set\RelationSet;

/**
 * @template-extends RelationSet<Version, Category>
 */
final class CategoriesOfVersionCollection extends RelationSet
{
    protected function shouldAdd(mixed $entry): bool
    {
        if ($entry->version !== $this->parent) {
            throw new \LogicException('Could not change category relation');
        }

        return parent::shouldAdd($entry);
    }
}
