<?php

declare(strict_types=1);

namespace App\Application\UseCase\GetArticleByName;

use App\Domain\Blog\Article;

final readonly class GetArticleByNameResult
{
    public function __construct(
        public Article $article,
    ) {}
}
