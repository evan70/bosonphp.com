<?php

declare(strict_types=1);

namespace App\Blog\Domain\Category\Repository;

use App\Blog\Domain\Category\ArticleCategory;

interface ArticleCategoryListProviderInterface
{
    /**
     * @return iterable<array-key, ArticleCategory>
     */
    public function getAll(): iterable;
}
