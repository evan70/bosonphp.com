<?php

declare(strict_types=1);

namespace App\Blog\Domain\Category\Repository;

use App\Blog\Domain\Category\ArticleCategory;

interface ArticleCategoryBySlugProviderInterface
{
    /**
     * @param non-empty-string $slug
     */
    public function findBySlug(string $slug): ?ArticleCategory;
}
