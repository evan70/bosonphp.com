<?php

namespace App\Blog\Application\Output;

use App\Blog\Domain\Article;

/**
 * Represents a full blog article output.
 */
final readonly class FullArticleOutput extends ArticleOutput
{
    /**
     * @param non-empty-string $title
     * @param non-empty-string $uri
     */
    public function __construct(
        string $title,
        string $uri,
        /**
         * The rendered content of the article in HTML format.
         *
         * @var string
         */
        public string $content,
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
            content: $article->content->rendered,
        );
    }
}
