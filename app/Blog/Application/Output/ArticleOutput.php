<?php

namespace App\Blog\Application\Output;

use App\Blog\Domain\Article;

/**
 * Represents common blog article output.
 */
abstract readonly class ArticleOutput
{
    public function __construct(
        /**
         * The title of the article.
         *
         * @var non-empty-string
         */
        public string $title,
        /**
         * The unique URI slug of the article.
         *
         * @var non-empty-string
         */
        public string $uri,
    ) {}

    abstract public static function fromArticle(Article $article): static;
}
