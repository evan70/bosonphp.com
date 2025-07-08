<?php

namespace App\Blog\Domain\Category;

use App\Blog\Domain\Article;
use Local\Component\Set\RelationSet;

/**
 * @template-extends RelationSet<ArticleCategory, Article>
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
