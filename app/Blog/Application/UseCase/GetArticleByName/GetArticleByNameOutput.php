<?php

declare(strict_types=1);

namespace App\Blog\Application\UseCase\GetArticleByName;

use App\Blog\Application\Output\Article\FullArticleOutput;
use App\Blog\Application\Output\Category\CategoryOutput;

final readonly class GetArticleByNameOutput
{
    public function __construct(
        /**
         * The unique URI slug of the article.
         *
         * @var non-empty-string
         */
        public string $uri,
        /**
         * The category information for the article.
         */
        public CategoryOutput $category,
        /**
         * The full article content and metadata.
         */
        public FullArticleOutput $article,
    ) {}
}
