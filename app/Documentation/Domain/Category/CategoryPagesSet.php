<?php

declare(strict_types=1);

namespace App\Documentation\Domain\Category;

use App\Documentation\Domain\Page;
use Local\Component\Set\RelationSet;

/**
 * @template-extends RelationSet<Category, Page>
 */
final class CategoryPagesSet extends RelationSet
{
    protected function shouldAdd(mixed $entry): bool
    {
        if ($entry->category !== $this->parent) {
            $entry->category = $this->parent;
        }

        return parent::shouldAdd($entry);
    }
}
