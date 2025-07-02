<?php

declare(strict_types=1);

namespace App\Domain\Blog\Category\Repository;

use App\Domain\Blog\Category\ArticleCategory;

interface ArticleCategoryBySlugProviderInterface
{
    /**
     * @param non-empty-string $slug
     */
    public function findBySlug(string $slug): ?ArticleCategory;
}
