<?php

declare(strict_types=1);

namespace App\Domain\Documentation;

use App\Domain\Documentation\Category\Category;
use Local\Component\Set\RelationSet;

/**
 * @template-extends RelationSet<Category, Page>
 */
final class PagesOfCategoryCollection extends RelationSet
{
    protected function shouldAdd(mixed $entry): bool
    {
        if ($entry->category !== $this->parent) {
            throw new \LogicException('Could not change category relation');
        }

        return parent::shouldAdd($entry);
    }
}
