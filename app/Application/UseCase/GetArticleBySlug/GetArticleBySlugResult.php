<?php

declare(strict_types=1);

namespace App\Application\UseCase\GetArticleBySlug;

use App\Domain\Blog\Article;

final readonly class GetArticleBySlugResult
{
    public function __construct(
        public Article $article,
    ) {}
}
