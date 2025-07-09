<?php

declare(strict_types=1);

namespace App\Blog\Domain\Category;

use App\Blog\Domain\Article;
use Local\Component\Set\RelationSet;

/**
 * @template-extends RelationSet<Category, Article>
 */
final class CategoryArticleSet extends RelationSet
{
    protected function shouldAdd(mixed $entry): bool
    {
        if ($entry->category !== $this->parent) {
            $entry->category = $this->parent;
        }

        return parent::shouldAdd($entry);
    }
}
