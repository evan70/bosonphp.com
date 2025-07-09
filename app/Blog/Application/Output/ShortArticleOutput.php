<?php

declare(strict_types=1);

namespace App\Blog\Application\Output;

use App\Blog\Domain\Article;

/**
 * Represents a short/preview blog article output.
 */
final readonly class ShortArticleOutput extends ArticleOutput
{
    /**
     * @param non-empty-string $title
     * @param non-empty-string $uri
     */
    public function __construct(
        string $title,
        string $uri,
        /**
         * The preview text of the article content.
         *
         * @var string
         */
        public string $preview,
    ) {
        parent::__construct(
            title: $title,
            uri: $uri,
        );
    }

    public static function fromArticle(Article $article): static
    {
        return new self(
            title: $article->title,
            uri: $article->uri,
            preview: $article->preview,
        );
    }
}
