<?php

declare(strict_types=1);

namespace App\Domain\Blog\Repository;

use App\Domain\Blog\Article;

interface ArticleBySlugProviderInterface
{
    /**
     * @param non-empty-string $slug
     */
    public function findBySlug(string $slug): ?Article;
}
