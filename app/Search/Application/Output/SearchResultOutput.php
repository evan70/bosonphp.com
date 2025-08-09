<?php

declare(strict_types=1);

namespace App\Search\Application\Output;

use App\Search\Domain\SearchResult;

final readonly class SearchResultOutput
{
    public function __construct(
        /**
         * @var non-empty-string
         */
        public string $category,
        /**
         * @var non-empty-string
         */
        public string $version,
        /**
         * @var non-empty-string
         */
        public string $title,
        /**
         * @var non-empty-string
         */
        public string $uri,
        public string $content,
    ) {}

    public static function fromSearchResult(SearchResult $result): self
    {
        return new self(
            category: $result->category,
            version: $result->version,
            title: $result->title,
            uri: $result->uri,
            content: $result->content,
        );
    }
}
