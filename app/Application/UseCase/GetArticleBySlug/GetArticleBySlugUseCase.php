<?php

declare(strict_types=1);

namespace App\Application\UseCase\GetArticleBySlug;

use App\Application\UseCase\GetArticleBySlug\Exception\ArticleNotFoundException;
use App\Application\UseCase\GetArticleBySlug\Exception\InvalidSlugException;
use App\Domain\Blog\ArticleRepositoryInterface;

final readonly class GetArticleBySlugUseCase
{
    public function __construct(
        private ArticleRepositoryInterface $articles,
    ) {}

    public function getArticle(string $slug): GetArticleBySlugResult
    {
        $slug = \trim($slug);

        if ($slug === '') {
            throw new InvalidSlugException();
        }

        $article = $this->articles->findBySlug($slug);

        if ($article === null) {
            throw new ArticleNotFoundException();
        }

        return new GetArticleBySlugResult(
            article: $article,
        );
    }
}
