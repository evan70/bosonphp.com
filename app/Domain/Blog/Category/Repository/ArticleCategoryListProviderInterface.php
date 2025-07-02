<?php

declare(strict_types=1);

namespace App\Domain\Blog\Category\Repository;

use App\Domain\Blog\Category\ArticleCategory;

interface ArticleCategoryListProviderInterface
{
    /**
     * @return iterable<array-key, ArticleCategory>
     */
    public function getAll(): iterable;
}
