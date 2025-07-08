<?php

declare(strict_types=1);

namespace App\Blog\Domain\Repository;

use App\Blog\Domain\Article;

interface ArticleBySlugProviderInterface
{
    /**
     * @param non-empty-string $slug
     */
    public function findBySlug(string $slug): ?Article;
}
