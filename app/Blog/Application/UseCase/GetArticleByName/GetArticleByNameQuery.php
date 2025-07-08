<?php

declare(strict_types=1);

namespace App\Blog\Application\UseCase\GetArticleByName;

/**
 * Query object for retrieving a blog article by its URI.
 */
final readonly class GetArticleByNameQuery
{
    public function __construct(
        /**
         * The unique URI slug of the article to retrieve.
         */
        public string $uri,
    ) {}
}
