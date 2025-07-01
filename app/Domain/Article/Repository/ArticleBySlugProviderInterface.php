<?php

declare(strict_types=1);

namespace App\Domain\Article\Repository;

use App\Domain\Article\Article;

interface ArticleBySlugProviderInterface
{
    /**
     * @param non-empty-string $slug
     */
    public function findBySlug(string $slug): ?Article;
}
