<?php

declare(strict_types=1);

namespace App\Search\Domain;

use App\Shared\Domain\AggregateRootInterface;

final readonly class SearchResult implements AggregateRootInterface
{
    public function __construct(
        public SearchResultId $id,
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
        public float $rank,
    ) {}
}
