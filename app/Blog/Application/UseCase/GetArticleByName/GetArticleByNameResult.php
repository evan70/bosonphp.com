<?php

declare(strict_types=1);

namespace App\Blog\Application\UseCase\GetArticleByName;

use App\Blog\Domain\Article;

final readonly class GetArticleByNameResult
{
    public function __construct(
        public Article $article,
    ) {}
}
