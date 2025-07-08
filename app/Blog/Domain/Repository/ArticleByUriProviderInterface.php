<?php

declare(strict_types=1);

namespace App\Blog\Domain\Repository;

use App\Blog\Domain\Article;

interface ArticleByUriProviderInterface
{
    /**
     * @param non-empty-string $uri
     */
    public function findByUri(string $uri): ?Article;
}
