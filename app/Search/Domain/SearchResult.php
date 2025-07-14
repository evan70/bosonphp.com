<?php

declare(strict_types=1);

namespace App\Search\Domain;

final readonly class SearchResult
{
    public function __construct(
        public SearchResultId $id,
        /**
         * @var non-empty-string
         */
        public string $title,
        /**
         * @var non-empty-string
         */
        public string $uri,
        public string $content,
        public float $rank,
    ) {}
}
